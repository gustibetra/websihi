<?php

namespace App\Livewire\Admin;

use App\Models\Menu;
use App\Models\Page;
use App\Models\Common;
use App\Models\Program;
use App\Services\LookupService;
use Livewire\Component;
use Livewire\WithPagination;

class MenuManager extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    
    // Filter properties
    public $locationFilter = 'header';
    public $initialLocation = null; // can be passed from parent
    
    // Form properties
    public $showModal = false;
    public $editMode = false;
    public $menuId = null;
    public $form = [];
    
    // Info modal
    public $showInfoModal = false;
    public $selectedMenu = null;
    
    protected $listeners = ['menuReordered' => 'handleReorder'];
    
    public function mount()
    {
        $this->locationFilter = $this->initialLocation ?? 'header';
    }
    
    public function updatingLocationFilter()
    {
        $this->resetPage();
    }
    
    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->form['location'] = $this->locationFilter;
        $this->form['link_type'] = 'url';
        $this->form['is_active'] = true;
        $this->form['open_new_tab'] = false;
        $this->showModal = true;
        $this->dispatch('modal-opened');
    }
    
    public function openEditModal($id)
    {
        $this->resetForm();
        $this->editMode = true;
        $this->menuId = $id;
        
        $menu = Menu::find($id);
        if ($menu) {
            $this->form = [
                'parent_id' => $menu->parent_id,
                'location' => $menu->location,
                'title' => $menu->title,
                'slug' => $menu->slug,
                'link_type' => $menu->link_type,
                'page_id' => $menu->page_id,
                'structure_id' => $menu->structure_id,
                'custom_url' => $menu->custom_url,
                'icon' => $menu->icon,
                'css_class' => $menu->css_class,
                'is_active' => $menu->is_active,
                'open_new_tab' => $menu->open_new_tab,
                'description' => $menu->description,
            ];
        }
        
        $this->showModal = true;
        $this->dispatch('modal-opened');
    }
    
    public function save()
    {
        try {
            $this->validate($this->getRules());
            
            $data = $this->form;
            
            // Set order for new menu
            if (!$this->editMode) {
                $maxOrder = Menu::where('location', $data['location'])
                    ->where('parent_id', $data['parent_id'] ?? null)
                    ->max('order');
                $data['order'] = ($maxOrder ?? 0) + 1;
            }
            
            // Clear unused fields based on link_type
            if ($data['link_type'] === 'page') {
                $data['structure_id'] = null;
                $data['custom_url'] = null;
            } elseif ($data['link_type'] === 'structure') {
                $data['custom_url'] = null;
            } elseif ($data['link_type'] === 'route' || $data['link_type'] === 'url') {
                $data['page_id'] = null;
                $data['structure_id'] = null;
            } elseif ($data['link_type'] === 'group') {
                $data['page_id'] = null;
                $data['structure_id'] = null;
                $data['custom_url'] = null;
            }
            
            if ($this->editMode) {
                $data['updated_by'] = auth()->id();
                Menu::find($this->menuId)->update($data);
                $message = 'Menu berhasil diupdate';
            } else {
                $data['created_by'] = auth()->id();
                Menu::create($data);
                $message = 'Menu berhasil ditambahkan';
            }
            
            $this->showModal = false;
            $this->resetForm();
            session()->flash('message', $message);
            $this->dispatch('menu-updated');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function delete($id)
    {
        try {
            $menu = Menu::find($id);
            
            if (!$menu) {
                session()->flash('error', 'Menu tidak ditemukan');
                return;
            }
            
            // Check if has children
            if ($menu->hasChildren()) {
                session()->flash('error', 'Menu memiliki sub-menu. Hapus sub-menu terlebih dahulu.');
                return;
            }
            
            $menu->delete();
            session()->flash('message', 'Menu berhasil dihapus');
            $this->dispatch('menu-updated');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function toggleStatus($id)
    {
        try {
            $menu = Menu::find($id);
            
            if (!$menu) {
                session()->flash('error', 'Menu tidak ditemukan');
                return;
            }
            
            $menu->update(['is_active' => !$menu->is_active]);
            session()->flash('message', 'Status menu berhasil diupdate');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function handleReorder($orderedIds)
    {
        try {
            foreach ($orderedIds as $index => $id) {
                Menu::where('id', $id)->update(['order' => $index + 1]);
            }
            
            session()->flash('message', 'Urutan menu berhasil diupdate');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function handleReorderChildren($parentId, $orderedIds)
    {
        try {
            foreach ($orderedIds as $index => $id) {
                Menu::where('id', $id)->update([
                    'order' => $index + 1,
                    'parent_id' => $parentId
                ]);
            }
            
            session()->flash('message', 'Urutan sub-menu berhasil diupdate');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function updateMenuParent($menuId, $newParentId)
    {
        try {
            $menu = Menu::find($menuId);
            
            if (!$menu) {
                session()->flash('error', 'Menu tidak ditemukan');
                return;
            }
            
            // Prevent circular reference
            if ($newParentId && $this->isCircularReference($menuId, $newParentId)) {
                session()->flash('error', 'Tidak bisa menjadikan child sebagai parent');
                return;
            }
            
            // Update parent
            $menu->update([
                'parent_id' => $newParentId,
                'updated_by' => auth()->id()
            ]);
            
            // Reorder
            if ($newParentId) {
                $siblings = Menu::where('parent_id', $newParentId)->orderBy('order')->get();
                foreach ($siblings as $index => $sibling) {
                    $sibling->update(['order' => $index + 1]);
                }
            } else {
                $siblings = Menu::where('location', $menu->location)
                    ->whereNull('parent_id')
                    ->orderBy('order')
                    ->get();
                foreach ($siblings as $index => $sibling) {
                    $sibling->update(['order' => $index + 1]);
                }
            }
            
            session()->flash('message', 'Menu berhasil dipindahkan');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    private function isCircularReference($menuId, $newParentId)
    {
        $parent = Menu::find($newParentId);
        
        while ($parent) {
            if ($parent->id === $menuId) {
                return true;
            }
            $parent = $parent->parent;
        }
        
        return false;
    }
    
    public function openInfoModal($id)
    {
        $this->selectedMenu = Menu::with(['page', 'structure', 'parent', 'children'])->find($id);
        if ($this->selectedMenu) {
            $this->showInfoModal = true;
        }
    }
    
    protected function resetForm()
    {
        $this->form = [];
        $this->menuId = null;
        $this->resetValidation();
    }
    
    public function getRules()
    {
        return [
            'form.parent_id' => 'nullable|exists:menus,id',
            'form.location' => ['required', 'string', function ($attribute, $value, $fail) {
                $validLocations = ['header', 'footer'];
                $programs = Program::where('is_active', true)->get();
                foreach ($programs as $p) {
                    $validLocations[] = 'jurusan_' . strtolower($p->kode);
                }
                if (!in_array($value, $validLocations)) {
                    $fail('Lokasi menu tidak valid.');
                }
            }],
            'form.title' => 'required|string|max:100',
            'form.slug' => 'nullable|string|max:150',
            'form.link_type' => 'required|in:page,structure,route,url,group',
            'form.page_id' => 'nullable|exists:pages,id',
            'form.structure_id' => 'nullable|exists:common,id',
            'form.custom_url' => 'nullable|string|max:255',
            'form.icon' => 'nullable|string|max:100',
            'form.css_class' => 'nullable|string|max:100',
            'form.is_active' => 'boolean',
            'form.open_new_tab' => 'boolean',
            'form.description' => 'nullable|string',
        ];
    }
    
    /**
     * Get flattened menu list with hierarchy (max 2 levels: parent and child only)
     */
    private function getFlattenedMenus($menus, $level = 0, $maxLevel = 1)
    {
        $result = [];
        
        foreach ($menus as $menu) {
            $menu->level = $level;
            $result[] = $menu;
            
            // Only include children if we haven't reached max level
            if ($level < $maxLevel && $menu->children && $menu->children->count() > 0) {
                $childResults = $this->getFlattenedMenus($menu->children, $level + 1, $maxLevel);
                $result = array_merge($result, $childResults);
            }
        }
        
        return $result;
    }
    
    public function render()
    {
        $menus = Menu::with(['page', 'structure', 'parent', 'childrenRecursive.page', 'childrenRecursive.structure'])
            ->where('location', $this->locationFilter)
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();
        
        // Get lookup data
        $pages = Page::where('is_active', true)
            ->where('page_type', 'page')
            ->orderBy('title')
            ->get();
        
        $structurePages = Page::where('is_active', true)
            ->where('page_type', 'structure')
            ->orderBy('title')
            ->get();
        
        // Get parent menu options in hierarchical order
        $allMenus = Menu::with(['childrenRecursive'])
            ->where('location', $this->locationFilter)
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();
        
        $parentMenus = collect($this->getFlattenedMenus($allMenus));
        
        // Exclude current menu when editing to prevent self-reference and circular reference
        if ($this->editMode && $this->menuId) {
            $parentMenus = $parentMenus->filter(function($menu) {
                return $menu->id != $this->menuId;
            });
        }
        
        return view('livewire.admin.menu-manager', [
            'menus' => $menus,
            'pages' => $pages,
            'structurePages' => $structurePages,
            'parentMenus' => $parentMenus,
            'programs' => Program::where('is_active', true)->orderBy('order')->get(),
        ]);
    }
}
