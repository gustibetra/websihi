document.addEventListener('DOMContentLoaded', function() {
    const clickableCards = document.querySelectorAll('.member-card-clickable');
    const modalEl = document.getElementById('memberDetailModal');
    
    if (clickableCards.length > 0 && modalEl) {
        const bsModal = new bootstrap.Modal(modalEl);
        
        clickableCards.forEach(card => {
            card.addEventListener('click', function() {
                const photo    = this.getAttribute('data-member-photo') || '';
                const name     = this.getAttribute('data-member-name') || '';
                const position = this.getAttribute('data-member-position') || '-';
                const structure= this.getAttribute('data-member-structure') || '-';
                const period   = this.getAttribute('data-member-period') || '-';
                const fraction = this.getAttribute('data-member-fraction') || '-';
                const party    = this.getAttribute('data-member-party') || '-';
                const dapil    = this.getAttribute('data-member-dapil') || '-';
                
                // Photo vs fallback icon
                const modalPhoto    = document.getElementById('memberDetailPhoto');
                const modalFallback = document.getElementById('memberDetailPhotoFallback');
                if (modalPhoto && modalFallback) {
                    if (photo) {
                        modalPhoto.src     = photo;
                        modalPhoto.alt     = name;
                        modalPhoto.style.display  = 'block';
                        modalFallback.style.display = 'none';
                    } else {
                        modalPhoto.src    = '';
                        modalPhoto.style.display  = 'none';
                        modalFallback.style.display = 'inline-block';
                    }
                }

                // Text fields
                const set = (id, val) => { const el = document.getElementById(id); if (el) el.innerText = val; };
                set('memberDetailName',      name);
                set('memberDetailPosition',  position);
                set('memberDetailStructure', structure);
                set('memberDetailPeriod',    period);
                set('memberDetailFraction',  fraction);
                set('memberDetailParty',     party);
                set('memberDetailDapil',     dapil);
                
                bsModal.show();
            });
            
            // Keyboard accessibility (Space or Enter)
            card.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
    }
});

