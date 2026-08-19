<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\SettingService;
use App\Services\FileUploadService;
use App\Services\SecuritySettingService;
use App\Models\Common;
use App\Models\News;
use App\Models\Program;

class SettingsManager extends Component
{
    use WithFileUploads;

    public $selectedSection = 'institution';
    public $setting;
    public $tempLogo;
    public $tempLogoSquare;
    public $tempFavicon;

    // Institution fields
    public $institution_name = '';
    public $address = '';
    public $email = '';
    public $phone = '';
    public $fax = '';
    public $website = '';
    public $google_map = '';
    public $description = '';
    public $vision = '';
    public $mission = '';
    public $active_period = '';
    
    // Social media (for frontend section)
    public $facebook = '';
    public $instagram = '';
    public $twitter = '';
    public $youtube = '';
    public $whatsapp = '';
    public $tiktok = '';
    public $ppdb_link = '';

    // Security settings
    public $ip_filtering_enabled = false;
    public $user_agent_filtering_enabled = false;
    public $rate_limiting_enabled = false;
    public $rate_limit_per_hour = 100;
    public $security_logging_enabled = false;
    public $disable_devtools = false;

    // SEO Settings fields
    public $seo_meta_title = '';
    public $seo_meta_description = '';
    public $seo_meta_keywords = '';
    public $seo_google_analytics = '';
    public $seo_google_verification = '';
    public $seo_og_image = '';
    public $tempOgImage = null;

    // Home Sections Settings
    public $selectedSubTab = 'menu'; // menu, home, theme_seo, menu_jurusan
    public $homeSections = [];
    public $editingSectionKey = null;
    public $editingSectionData = [];
    public $tempPhoto1 = null;
    public $selectedJurusanKode = null; // for menu jurusan tab

    // Hero Banner CRUD fields
    public $bannerList = [];
    public $showBannerForm = false;
    public $bannerEditMode = false;
    public $bannerId = null;
    public $banner_motivation = '';
    public $banner_detail = '';
    public $banner_button_text = '';
    public $banner_url = '';
    public $banner_status = true;
    public $tempBannerPhoto = null;
    public $existingBannerPhoto = null;

    // Karya Siswa CRUD fields
    public $karyaList = [];
    public $showKaryaForm = false;
    public $karyaEditMode = false;
    public $karyaId = null;
    public $karya_judul = '';
    public $karya_deskripsi = '';
    public $karya_jurusan_id = '';
    public $karya_berita_id = '';
    public $karya_status = true;
    public $tempKaryaPhoto = null;
    public $existingKaryaPhoto = null;
    public $newsSearch = '';

    // Social Media settings tab fields
    public $social_instagram_url = '';
    public $social_show_instagram = false;
    public $social_instagram_embed = '';
    
    public $social_youtube_url = '';
    public $social_show_youtube = false;
    public $social_youtube_embed = '';
    
    public $social_facebook_url = '';
    public $social_show_facebook = false;
    public $social_facebook_embed = '';
    
    public $social_tiktok_url = '';
    public $social_show_tiktok = false;
    public $social_tiktok_embed = '';

    protected $settingService;
    protected $fileService;
    protected $securitySettingService;

    public function boot(
        SettingService $settingService, 
        FileUploadService $fileService,
        SecuritySettingService $securitySettingService
    ) {
        $this->settingService = $settingService;
        $this->fileService = $fileService;
        $this->securitySettingService = $securitySettingService;
    }

    public function mount()
    {
        $this->loadSettings();
        $this->loadSecuritySettings();
        $this->loadHomeSections();
        $this->loadSeoSettings();
        $this->loadSocialMediaSettings();
    }

    public function selectSection($section)
    {
        $this->selectedSection = $section;
        $this->cancelEditSection();
        $this->showKaryaForm = false;
        $this->showBannerForm = false;
        $this->selectedJurusanKode = null;
    }

    public function selectJurusanMenu(?string $kode)
    {
        $this->selectedJurusanKode = $kode;
    }

    public function loadSettings()
    {
        $result = $this->settingService->get();
        if ($result['success'] && $result['data']) {
            $this->setting = $result['data'];
            
            // Load institution data
            $this->institution_name = $this->setting->institution_name ?? '';
            $this->address = $this->setting->address ?? '';
            $this->email = $this->setting->email ?? '';
            $this->phone = $this->setting->phone ?? '';
            $this->fax = $this->setting->fax ?? '';
            $this->website = $this->setting->website ?? '';
            $this->google_map = $this->setting->google_map ?? '';
            $this->description = $this->setting->description ?? '';
            $this->vision = $this->setting->vision ?? '';
            $this->mission = $this->setting->mission ?? '';
            $this->active_period = $this->setting->active_period ?? '';
            
            // Load social media
            $this->facebook = $this->setting->facebook ?? '';
            $this->instagram = $this->setting->instagram ?? '';
            $this->twitter = $this->setting->twitter ?? '';
            $this->youtube = $this->setting->youtube ?? '';
            $this->whatsapp = $this->setting->whatsapp ?? '';
            $this->tiktok   = $this->setting->tiktok ?? '';
            $this->ppdb_link = $this->setting->ppdb_link ?? '';
        }
    }

    public function save()
    {
        $this->validate([
            'institution_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
        ]);

        try {
            $data = [
                'institution_name' => $this->institution_name,
                'address' => $this->address,
                'email' => $this->email,
                'phone' => $this->phone,
                'fax' => $this->fax,
                'website' => $this->website,
                'google_map' => $this->google_map,
                'description' => $this->description,
                'vision' => $this->vision,
                'mission' => $this->mission,
                'active_period' => $this->active_period,
                'facebook' => $this->facebook,
                'instagram' => $this->instagram,
                'twitter' => $this->twitter,
                'youtube' => $this->youtube,
                'whatsapp' => $this->whatsapp,
                'tiktok' => $this->tiktok,
                'ppdb_link' => $this->ppdb_link,
                'updated_by' => auth()->id(),
            ];

            // Only include file uploads if they exist
            if ($this->tempLogo) {
                $data['logo'] = $this->tempLogo;
            }
            
            if ($this->tempLogoSquare) {
                $data['logo_square'] = $this->tempLogoSquare;
            }
            
            if ($this->tempFavicon) {
                $data['favicon'] = $this->tempFavicon;
            }

            $result = $this->settingService->update($data);

            if ($result['success']) {
                session()->flash('success', 'Pengaturan berhasil disimpan');
                $this->tempLogo = null;
                $this->tempLogoSquare = null;
                $this->tempFavicon = null;
                $this->loadSettings();
            } else {
                session()->flash('error', $result['message']);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function loadSeoSettings()
    {
        $seo = Common::where('table_name', 'seo_setting')
            ->where('key1', 'seo_config')
            ->first();

        if ($seo) {
            $this->seo_meta_title = $seo->data1 ?? '';
            $this->seo_google_analytics = $seo->data2 ?? '';
            $this->seo_google_verification = $seo->data3 ?? '';
            $this->seo_og_image = $seo->data4 ?? '';
            $this->seo_meta_description = $seo->text1 ?? '';
            $this->seo_meta_keywords = $seo->text2 ?? '';
        } else {
            // Populate defaults from basic settings if not initialized
            $this->seo_meta_title = $this->institution_name;
            $this->seo_meta_description = $this->description;
        }
    }

    public function saveSeoSettings()
    {
        $this->validate([
            'seo_meta_title' => 'required|string|max:255',
            'seo_meta_description' => 'nullable|string|max:500',
            'seo_meta_keywords' => 'nullable|string|max:255',
            'seo_google_analytics' => 'nullable|string|max:100',
            'seo_google_verification' => 'nullable|string|max:255',
            'tempOgImage' => 'nullable|image|max:2048', // Max 2MB
        ]);

        try {
            $seo = Common::firstOrCreate([
                'table_name' => 'seo_setting',
                'key1' => 'seo_config'
            ], [
                'is_active' => true,
                'order' => 1,
                'created_by' => auth()->id()
            ]);

            $photoPath = $seo->data4;

            if ($this->tempOgImage) {
                // Delete old OG image if exists
                if ($seo->data4) {
                    $this->fileService->delete($seo->data4);
                }
                // Upload new image (standard resizing to 1200x630 for Facebook/OpenGraph recommendations)
                $photoPath = $this->fileService->uploadAndResize($this->tempOgImage, 'seo', 1200, 630);
            }

            $seo->update([
                'data1' => $this->seo_meta_title,
                'data2' => $this->seo_google_analytics,
                'data3' => $this->seo_google_verification,
                'data4' => $photoPath,
                'text1' => $this->seo_meta_description,
                'text2' => $this->seo_meta_keywords,
                'updated_by' => auth()->id()
            ]);

            $this->tempOgImage = null;
            $this->loadSeoSettings();

            session()->flash('success', 'SEO & Tampilan settings berhasil disimpan');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan SEO settings: ' . $e->getMessage());
        }
    }

    public function loadSocialMediaSettings()
    {
        $social = Common::where('table_name', 'social_media_setting')
            ->where('key1', 'social_media_config')
            ->first();

        if ($social) {
            $this->social_instagram_url = $social->data1 ?? '';
            $this->social_show_instagram = ($social->data2 ?? '0') === '1';
            $this->social_instagram_embed = $social->text1 ?? '';
            
            $this->social_youtube_url = $social->data3 ?? '';
            $this->social_show_youtube = ($social->data4 ?? '0') === '1';
            $this->social_youtube_embed = $social->text2 ?? '';
            
            $this->social_facebook_url = $social->data5 ?? '';
            $this->social_show_facebook = ($social->data6 ?? '0') === '1';
            $this->social_facebook_embed = $social->text3 ?? '';
            
            $this->social_tiktok_url = $social->data7 ?? '';
            $this->social_show_tiktok = ($social->data8 ?? '0') === '1';
            $this->social_tiktok_embed = $social->text4 ?? '';
        }
    }

    public function saveSocialMediaSettings()
    {
        try {
            $social = Common::firstOrCreate([
                'table_name' => 'social_media_setting',
                'key1' => 'social_media_config'
            ], [
                'created_by' => auth()->id()
            ]);

            $social->update([
                'data1' => $this->social_instagram_url ?: null,
                'data2' => $this->social_show_instagram ? '1' : '0',
                'text1' => $this->social_instagram_embed ?: null,
                
                'data3' => $this->social_youtube_url ?: null,
                'data4' => $this->social_show_youtube ? '1' : '0',
                'text2' => $this->social_youtube_embed ?: null,
                
                'data5' => $this->social_facebook_url ?: null,
                'data6' => $this->social_show_facebook ? '1' : '0',
                'text3' => $this->social_facebook_embed ?: null,
                
                'data7' => $this->social_tiktok_url ?: null,
                'data8' => $this->social_show_tiktok ? '1' : '0',
                'text4' => $this->social_tiktok_embed ?: null,
                
                'updated_by' => auth()->id()
            ]);

            $this->loadSocialMediaSettings();
            session()->flash('success', 'Pengaturan Social Media berhasil disimpan');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan Social Media settings: ' . $e->getMessage());
        }
    }

    public function saveWhatsapp()
{
    try {
        $setting = \App\Models\Setting::first();
        if ($setting) {
            $setting->whatsapp = $this->whatsapp;
            $setting->save();
        }
        $this->loadSettings();
        session()->flash('success', 'Nomor WhatsApp berhasil disimpan');
    } catch (\Exception $e) {
        session()->flash('error', 'Gagal menyimpan WhatsApp: ' . $e->getMessage());
    }
}

    public function loadSecuritySettings()
    {
        $result = $this->securitySettingService->getAll();
        if ($result['success']) {
            $settings = $result['data'];
            $this->ip_filtering_enabled = ($settings['ip_filtering_enabled'] ?? '0') === '1';
            $this->user_agent_filtering_enabled = ($settings['user_agent_filtering_enabled'] ?? '1') === '1';
            $this->rate_limiting_enabled = ($settings['rate_limiting_enabled'] ?? '1') === '1';
            $this->rate_limit_per_hour = $settings['rate_limit_per_hour'] ?? 100;
            $this->security_logging_enabled = ($settings['security_logging_enabled'] ?? '1') === '1';
            $this->disable_devtools = ($settings['disable_devtools'] ?? '0') === '1';
        }
    }

    public function saveSecuritySettings()
    {
        try {
            $this->securitySettingService->updateSetting(
                'ip_filtering_enabled', 
                $this->ip_filtering_enabled ? '1' : '0',
                'Enable/disable IP filtering based on geolocation'
            );
            
            $this->securitySettingService->updateSetting(
                'user_agent_filtering_enabled', 
                $this->user_agent_filtering_enabled ? '1' : '0',
                'Enable/disable user agent filtering'
            );
            
            $this->securitySettingService->updateSetting(
                'rate_limiting_enabled', 
                $this->rate_limiting_enabled ? '1' : '0',
                'Enable/disable rate limiting'
            );
            
            $this->securitySettingService->updateSetting(
                'rate_limit_per_hour', 
                $this->rate_limit_per_hour,
                'Maximum requests per hour per IP'
            );
            
            $this->securitySettingService->updateSetting(
                'security_logging_enabled', 
                $this->security_logging_enabled ? '1' : '0',
                'Enable/disable security event logging'
            );

            $this->securitySettingService->updateSetting(
                'disable_devtools', 
                $this->disable_devtools ? '1' : '0',
                'Enable/disable blocking developer tools on public pages'
            );

            $this->loadSecuritySettings();

            session()->flash('success', 'Security settings berhasil disimpan');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function getSectionTitle()
    {
        $titles = [
            'institution' => 'Pengaturan Institusi',
            'frontend' => 'Pengaturan Frontend',
            'system' => 'Pengaturan Sistem',
        ];

        return $titles[$this->selectedSection] ?? 'Pengaturan';
    }

    // ─── Home Sections Management ───────────────────────────────────────────

    public function loadHomeSections()
    {
        $this->homeSections = Common::where('table_name', 'home_section')
            ->orderBy('order')
            ->get()
            ->toArray();
    }

    public function toggleSectionActive($id)
    {
        try {
            $section = Common::findOrFail($id);
            $section->update([
                'is_active' => !$section->is_active,
                'updated_by' => auth()->id()
            ]);
            $this->loadHomeSections();
            session()->flash('success', 'Status ' . $section->data1 . ' berhasil diperbarui');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    public function moveSectionUp($id)
    {
        try {
            $currentSection = Common::findOrFail($id);
            $previousSection = Common::where('table_name', 'home_section')
                ->where('order', '<', $currentSection->order)
                ->orderBy('order', 'desc')
                ->first();

            if ($previousSection) {
                $tempOrder = $currentSection->order;
                $currentSection->update(['order' => $previousSection->order]);
                $previousSection->update(['order' => $tempOrder]);
                
                $this->loadHomeSections();
                session()->flash('success', 'Urutan berhasil dipindahkan ke atas');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memindahkan urutan: ' . $e->getMessage());
        }
    }

    public function moveSectionDown($id)
    {
        try {
            $currentSection = Common::findOrFail($id);
            $nextSection = Common::where('table_name', 'home_section')
                ->where('order', '>', $currentSection->order)
                ->orderBy('order', 'asc')
                ->first();

            if ($nextSection) {
                $tempOrder = $currentSection->order;
                $currentSection->update(['order' => $nextSection->order]);
                $nextSection->update(['order' => $tempOrder]);
                
                $this->loadHomeSections();
                session()->flash('success', 'Urutan berhasil dipindahkan ke bawah');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memindahkan urutan: ' . $e->getMessage());
        }
    }

    public function editSection($key)
    {
        $this->editingSectionKey = $key;
        $section = Common::where('table_name', 'home_section')->where('key1', $key)->first();
        if ($section) {
            $this->editingSectionData = $section->toArray();
            $this->tempPhoto1 = null;
        }

        if ($key === 'karya_siswa') {
            $this->loadKaryaList();
        }

        if ($key === 'hero_banner') {
            $this->loadBannerList();
        }
    }

    public function cancelEditSection()
    {
        $this->editingSectionKey = null;
        $this->editingSectionData = [];
        $this->tempPhoto1 = null;
        $this->showKaryaForm = false;
        $this->showBannerForm = false;
    }

    public function saveSectionContent()
    {
        try {
            $key = $this->editingSectionKey;
            $section = Common::where('table_name', 'home_section')->where('key1', $key)->first();
            
            if ($section) {
                $data = [
                    'data2' => $this->editingSectionData['data2'] ?? null,
                    'data3' => $this->editingSectionData['data3'] ?? null,
                    'data4' => $this->editingSectionData['data4'] ?? null,
                    'data5' => $this->editingSectionData['data5'] ?? null,
                    'data6' => $this->editingSectionData['data6'] ?? null,
                    'data7' => $this->editingSectionData['data7'] ?? null,
                    'data8' => $this->editingSectionData['data8'] ?? null,
                    'data9' => $this->editingSectionData['data9'] ?? null,
                    'data10' => $this->editingSectionData['data10'] ?? null,
                    'data11' => $this->editingSectionData['data11'] ?? null,
                    'data12' => $this->editingSectionData['data12'] ?? null,
                    'data13' => $this->editingSectionData['data13'] ?? null,
                    'text1' => $this->editingSectionData['text1'] ?? null,
                    'text2' => $this->editingSectionData['text2'] ?? null,
                    'text3' => $this->editingSectionData['text3'] ?? null,
                    'updated_by' => auth()->id(),
                ];

                // Handle file upload
                if ($this->tempPhoto1) {
                    // Delete existing file if any
                    if ($section->data2) {
                        $this->fileService->delete($section->data2);
                    }
                    
                    // Upload new photo
                    if ($key === 'hero_banner') {
                        $data['data2'] = $this->fileService->uploadAndResize($this->tempPhoto1, 'home', 1920, 1080);
                    } elseif ($key === 'sambutan') {
                        $data['data2'] = $this->fileService->uploadAndResize($this->tempPhoto1, 'home', 500, 600);
                    } elseif ($key === 'school_life') {
                        $data['data2'] = $this->fileService->uploadAndResize($this->tempPhoto1, 'home', 800, 600);
                    } else {
                        $data['data2'] = $this->fileService->upload($this->tempPhoto1, 'home');
                    }
                }

                $section->update($data);
                $this->loadHomeSections();
                $this->cancelEditSection();
                session()->flash('success', 'Konten section ' . $section->data1 . ' berhasil disimpan');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan konten section: ' . $e->getMessage());
        }
    }

    // ─── Hero Banner CRUD ───────────────────────────────────────────────────

    public function loadBannerList()
    {
        $this->bannerList = Common::where('table_name', 'hero_banner_slide')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
    }

    public function openAddBanner()
    {
        $this->showBannerForm = true;
        $this->bannerEditMode = false;
        $this->bannerId = null;
        $this->banner_motivation = '';
        $this->banner_detail = '';
        $this->banner_button_text = '';
        $this->banner_url = '';
        $this->banner_status = true;
        $this->tempBannerPhoto = null;
        $this->existingBannerPhoto = null;
    }

    public function editBanner($id)
    {
        $banner = Common::findOrFail($id);
        $this->showBannerForm = true;
        $this->bannerEditMode = true;
        $this->bannerId = $id;
        $this->banner_motivation = $banner->data1 ?? '';
        $this->banner_detail = $banner->text1 ?? '';
        $this->banner_button_text = $banner->data3 ?? '';
        $this->banner_url = $banner->data4 ?? '';
        $this->banner_status = (bool)($banner->is_active ?? true);
        $this->existingBannerPhoto = $banner->data2 ?? null;
        $this->tempBannerPhoto = null;
    }

    public function saveBanner()
    {
        $this->validate([
            'banner_motivation' => 'required|string|max:255',
            'banner_detail' => 'nullable|string',
            'tempBannerPhoto' => 'nullable|image|max:2048',
        ]);

        try {
            $photoPath = $this->existingBannerPhoto;

            if ($this->tempBannerPhoto) {
                if ($this->existingBannerPhoto) {
                    $this->fileService->delete($this->existingBannerPhoto);
                }
                $photoPath = $this->fileService->uploadAndResize($this->tempBannerPhoto, 'hero_banner', 1920, 1080);
            }

            $data = [
                'table_name' => 'hero_banner_slide',
                'data1' => $this->banner_motivation,
                'text1' => $this->banner_detail,
                'data2' => $photoPath,
                'data3' => $this->banner_button_text ?: null,
                'data4' => $this->banner_url ?: null,
                'is_active' => $this->banner_status,
                'updated_by' => auth()->id(),
            ];

            if ($this->bannerEditMode) {
                $banner = Common::findOrFail($this->bannerId);
                $banner->update($data);
                session()->flash('success', 'Hero Banner berhasil diperbarui');
            } else {
                $data['created_by'] = auth()->id();
                $data['key1'] = 'HB' . time() . rand(10, 99);
                Common::create($data);
                session()->flash('success', 'Hero Banner berhasil ditambahkan');
            }

            $this->showBannerForm = false;
            $this->loadBannerList();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan Hero Banner: ' . $e->getMessage());
        }
    }

    public function deleteBanner($id)
    {
        try {
            $banner = Common::findOrFail($id);
            if ($banner->data2) {
                $this->fileService->delete($banner->data2);
            }
            $banner->delete();
            $this->loadBannerList();
            session()->flash('success', 'Hero Banner berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus Hero Banner: ' . $e->getMessage());
        }
    }

    public function toggleBannerActive($id)
    {
        try {
            $banner = Common::findOrFail($id);
            $banner->update([
                'is_active' => !$banner->is_active,
                'updated_by' => auth()->id()
            ]);
            $this->loadBannerList();
            session()->flash('success', 'Status Hero Banner berhasil diperbarui');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    // ─── Karya Siswa CRUD ───────────────────────────────────────────────────

    public function loadKaryaList()
    {
        $this->karyaList = Common::where('table_name', 'karya_siswa')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
    }

    public function openAddKarya()
    {
        $this->showKaryaForm = true;
        $this->karyaEditMode = false;
        $this->karyaId = null;
        $this->karya_judul = '';
        $this->karya_deskripsi = '';
        $this->karya_jurusan_id = '';
        $this->karya_berita_id = '';
        $this->newsSearch = '';
        $this->karya_status = true;
        $this->tempKaryaPhoto = null;
        $this->existingKaryaPhoto = null;
    }

    public function editKarya($id)
    {
        $karya = Common::findOrFail($id);
        $this->showKaryaForm = true;
        $this->karyaEditMode = true;
        $this->karyaId = $id;
        $this->karya_judul = $karya->data1 ?? '';
        $this->karya_deskripsi = $karya->text1 ?? '';
        $this->karya_jurusan_id = $karya->data3 ?? '';
        $this->karya_berita_id = $karya->data4 ?? '';
        $this->newsSearch = '';
        $this->karya_status = (bool)($karya->is_active ?? true);
        $this->existingKaryaPhoto = $karya->data2 ?? null;
        $this->tempKaryaPhoto = null;
    }

    public function saveKarya()
    {
        $this->validate([
            'karya_judul' => 'required|string|max:255',
            'karya_deskripsi' => 'nullable|string',
            'tempKaryaPhoto' => 'nullable|image|max:2048',
        ]);

        try {
            $photoPath = $this->existingKaryaPhoto;

            if ($this->tempKaryaPhoto) {
                if ($this->existingKaryaPhoto) {
                    $this->fileService->delete($this->existingKaryaPhoto);
                }
                $photoPath = $this->fileService->uploadAndResize($this->tempKaryaPhoto, 'karya_siswa', 800, 600);
            }

            $data = [
                'table_name' => 'karya_siswa',
                'data1' => $this->karya_judul,
                'text1' => $this->karya_deskripsi,
                'data2' => $photoPath,
                'data3' => $this->karya_jurusan_id ?: null,
                'data4' => $this->karya_berita_id ?: null,
                'is_active' => $this->karya_status,
                'updated_by' => auth()->id(),
            ];

            if ($this->karyaEditMode) {
                $karya = Common::findOrFail($this->karyaId);
                $karya->update($data);
                session()->flash('success', 'Karya Siswa berhasil diperbarui');
            } else {
                $data['created_by'] = auth()->id();
                // We generate a unique key if needed, or key1 can just be slug/random
                $data['key1'] = 'KR' . time() . rand(10, 99);
                Common::create($data);
                session()->flash('success', 'Karya Siswa berhasil ditambahkan');
            }

            $this->showKaryaForm = false;
            $this->loadKaryaList();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan Karya Siswa: ' . $e->getMessage());
        }
    }

    public function deleteKarya($id)
    {
        try {
            $karya = Common::findOrFail($id);
            if ($karya->data2) {
                $this->fileService->delete($karya->data2);
            }
            $karya->delete();
            $this->loadKaryaList();
            session()->flash('success', 'Karya Siswa berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus Karya Siswa: ' . $e->getMessage());
        }
    }

    public function toggleKaryaActive($id)
    {
        try {
            $karya = Common::findOrFail($id);
            $karya->update([
                'is_active' => !$karya->is_active,
                'updated_by' => auth()->id()
            ]);
            $this->loadKaryaList();
            session()->flash('success', 'Status Karya Siswa berhasil diperbarui');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    public function selectNews($id)
    {
        $this->karya_berita_id = $id;
        $this->newsSearch = '';
    }

    public function clearSelectedNews()
    {
        $this->karya_berita_id = '';
        $this->newsSearch = '';
    }

    public function render()
    {
        $newsResults = [];
        if (!empty($this->newsSearch)) {
            $newsResults = News::where('status', 'published')
                ->where(function($q) {
                    $q->where('title', 'like', '%' . $this->newsSearch . '%')
                      ->orWhere('id', $this->newsSearch);
                })
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get();
        }

        $selectedNews = null;
        if ($this->karya_berita_id) {
            $selectedNews = News::find($this->karya_berita_id);
        }

        return view('livewire.admin.settings-manager', [
            'programs' => Program::where('is_active', true)->orderBy('order')->get(),
            'newsResults' => $newsResults,
            'selectedNews' => $selectedNews,
        ]);
    }
}
