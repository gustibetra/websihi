{{-- Recursive Menu Item Component --}}
<div class="child-menu-item card mb-2 bg-light" data-id="{{ $menu->id }}" style="margin-left: {{ $level * 20 }}px;">
    <div class="card-body p-2">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0 me-2">
                <i class="ri-drag-move-2-line text-muted cursor-move"></i>
            </div>
            <div class="flex-grow-1">
                <small class="fw-semibold d-block">
                    @if($menu->children->count() > 0)
                        <i class="ri-arrow-down-s-line collapse-toggle collapsed me-1" 
                           id="toggle-{{ $menu->id }}"
                           onclick="event.stopPropagation(); var w=document.getElementById('child-wrapper-{{ $menu->id }}'); if(w){w.classList.toggle('collapsed'); this.classList.toggle('collapsed');}"></i>
                    @endif
                    @if($menu->icon)
                        <i class="{{ $menu->icon }} me-1"></i>
                    @endif
                    {{ $menu->title }}
                    @if($menu->link_type === 'group')
                        <span class="badge bg-secondary-subtle text-secondary ms-1" style="font-size: 0.65rem;">Group</span>
                    @endif
                    @if($menu->children->count() > 0)
                        <span class="badge bg-info-subtle text-info ms-1" style="font-size: 0.65rem;">{{ $menu->children->count() }}</span>
                    @endif
                </small>
                <small class="text-muted d-block" style="font-size: 0.7rem;">
                    @if($menu->link_type === 'page' && $menu->page)
                        <i class="ri-file-line"></i> Page: {{ $menu->page->title }}
                    @elseif($menu->link_type === 'structure' && $menu->page)
                        <i class="ri-organization-chart"></i> Structure: {{ $menu->page->title }}
                    @elseif($menu->link_type === 'route')
                        <i class="ri-route-line"></i> Route: {{ $menu->custom_url }}
                    @elseif($menu->link_type === 'url')
                        <i class="ri-link"></i> URL: {{ $menu->custom_url }}
                    @elseif($menu->link_type === 'group')
                        <i class="ri-folder-line"></i> Group Menu
                    @endif
                </small>
            </div>
            <div class="flex-shrink-0">
                @if($menu->is_active)
                    <span class="badge bg-success-subtle text-success me-1" style="font-size: 0.7rem;">Aktif</span>
                @else
                    <span class="badge bg-secondary-subtle text-secondary me-1" style="font-size: 0.7rem;">Nonaktif</span>
                @endif
                
                <div class="btn-group btn-group-sm">
                    <button type="button" 
                            class="btn btn-soft-primary btn-sm" 
                            wire:click="openEditModal({{ $menu->id }})"
                            title="Edit">
                        <i class="ri-pencil-line"></i>
                    </button>
                    <button type="button" 
                            class="btn btn-soft-danger btn-sm" 
                            onclick="confirmDelete({{ $menu->id }}, '{{ $menu->title }}')"
                            title="Hapus">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Recursive Children --}}
    @if($menu->children->count() > 0)
        <div class="child-menu-wrapper collapsed" id="child-wrapper-{{ $menu->id }}">
            <div class="child-menu-list">
                @foreach($menu->children as $child)
                    @include('livewire.admin.partials.menu-item', ['menu' => $child, 'level' => $level + 1])
                @endforeach
            </div>
        </div>
    @endif
</div>
