// Calendar & Events Logic for Homepage
(function() {
    let currentDate = new Date();
    let events = [];
    let apiUrl = '';
    let selectedDateStr = null;

    const monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    // Inject premium styles for calendar matching primary & secondary template theme
    const style = document.createElement('style');
    style.innerHTML = `
        .calendar-dates .date-cell {
            position: relative;
            background: #F5F6F8;
            border-radius: 8px;
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }
        .calendar-dates .date-cell .date-inner {
            font-size: 15px;
            font-weight: 600;
            color: var(--color-heading);
            user-select: none;
            z-index: 2;
        }
        .calendar-dates .date-cell:hover {
            background: #EAEBEE;
            transform: translateY(-1px);
        }
        .calendar-dates .date-cell.has-event {
            cursor: pointer;
            border: 1px solid var(--color-primary);
        }
        .calendar-dates .date-cell.has-event:hover {
            background: var(--color-primary-opacity, rgba(47, 87, 239, 0.12));
        }
        
        /* Today is colored as a solid primary theme block */
        .calendar-dates .date-cell.is-today {
            background: var(--color-primary) !important;
            border-color: var(--color-primary) !important;
            box-shadow: 0 3px 8px rgba(47, 87, 239, 0.3);
        }
        .calendar-dates .date-cell.is-today .date-inner {
            color: #fff !important;
            font-weight: 700;
        }
        
        /* Selected cell is colored as a solid secondary theme block */
        .calendar-dates .date-cell.selected-date {
            background: var(--color-secondary) !important;
            border-color: var(--color-secondary) !important;
            box-shadow: 0 4px 12px rgba(197, 134, 238, 0.4);
        }
        .calendar-dates .date-cell.selected-date .date-inner {
            color: #fff !important;
        }
        
        .calendar-dates .date-cell.selected-date .pin-badge svg path,
        .calendar-dates .date-cell.is-today .pin-badge svg path {
            fill: #fff !important;
        }
        
        .calendar-dates .date-cell.other-month {
            background: #FAFAFC;
            opacity: 0.4;
            cursor: default;
            border-color: transparent !important;
        }
        .calendar-dates .date-cell.other-month:hover {
            background: #FAFAFC;
            transform: none;
        }
        .event-item {
            transition: all 0.3s ease;
        }
    `;
    document.head.appendChild(style);

    // Initialize calendar
    window.initCalendar = function(initialEvents, url) {
        events = initialEvents;
        apiUrl = url;
        selectedDateStr = null;
        renderCalendar();
        renderEventList();
    };

    // Change Month (Triggered by navbar buttons)
    window.changeMonth = function(direction) {
        currentDate.setMonth(currentDate.getMonth() + direction);
        selectedDateStr = null; // Clear day filter on month change
        
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth() + 1; // 1-indexed for backend

        // Show loading state in calendar grid
        const calendarDates = document.getElementById('calendarDates');
        if (calendarDates) {
            calendarDates.innerHTML = '<div class="w-100 py-5 text-center text-muted" style="grid-column: span 7;"><i class="feather-loader spinning"></i> Loading...</div>';
        }

        // Fetch events for target month
        fetch(`${apiUrl}?year=${year}&month=${month}`)
            .then(response => response.json())
            .then(data => {
                events = data;
                renderCalendar();
                renderEventList();
            })
            .catch(error => {
                console.error('Error fetching calendar events:', error);
                // Fallback to empty events
                events = [];
                renderCalendar();
                renderEventList();
            });
    };

    // Helper: Normalize date formats to YYYY-MM-DD
    function formatDateString(dateInput) {
        if (!dateInput) return '';
        let d = typeof dateInput === 'string' ? new Date(dateInput) : dateInput;
        if (isNaN(d.getTime())) return '';
        
        let year = d.getFullYear();
        let month = String(d.getMonth() + 1).padStart(2, '0');
        let day = String(d.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Render Calendar Grid (matching user-submitted preview layout)
    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        // Update month heading title (uppercase matching preview)
        const currentMonthElem = document.getElementById('currentMonth');
        if (currentMonthElem) {
            currentMonthElem.textContent = `${monthNames[month]} ${year}`;
        }

        const calendarDatesElem = document.getElementById('calendarDates');
        if (!calendarDatesElem) return;

        calendarDatesElem.innerHTML = '';

        // Day of week offset (Grid starts on Monday: Sen, Sel, Rab, Kam, Jum, Sab, Min)
        let firstDay = new Date(year, month, 1).getDay(); // 0 (Sunday) to 6 (Saturday)
        firstDay = firstDay === 0 ? 6 : firstDay - 1; // Align: Monday as 0, Sunday as 6

        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const today = new Date();
        const todayStr = formatDateString(today);

        // Pre-populate trailing days of previous month
        const prevMonthDays = new Date(year, month, 0).getDate();
        for (let i = firstDay - 1; i >= 0; i--) {
            const prevDay = prevMonthDays - i;
            const prevCell = document.createElement('div');
            prevCell.className = 'date-cell other-month';
            prevCell.innerHTML = `<span class="date-inner">${prevDay}</span>`;
            calendarDatesElem.appendChild(prevCell);
        }

        // Build list of dates containing events
        const eventDatesMap = {};
        events.forEach(ev => {
            let dateStr = formatDateString(ev.start_datetime);
            if (dateStr) {
                eventDatesMap[dateStr] = true;
            }
        });

        // Populate current month's days
        for (let day = 1; day <= daysInMonth; day++) {
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const isToday = (dateStr === todayStr);
            const hasEvent = eventDatesMap[dateStr];

            const dateCell = document.createElement('div');
            dateCell.className = 'date-cell';
            if (isToday) dateCell.classList.add('is-today');
            if (hasEvent) dateCell.classList.add('has-event');
            if (selectedDateStr === dateStr) dateCell.classList.add('selected-date');

            dateCell.innerHTML = `<span class="date-inner">${day}</span>`;

            // If day has event, attach pushpin and click listener
            if (hasEvent) {
                // Add thumbtack pushpin icon (larger, matching user sketch)
                const pinBadge = document.createElement('div');
                pinBadge.className = 'pin-badge';
                pinBadge.style.cssText = 'position: absolute; top: 2px; right: 2px; line-height: 1; z-index: 5;';
                pinBadge.innerHTML = `
                    <svg viewBox="0 0 24 24" width="15" height="15" style="transform: rotate(45deg); display: block;">
                        <path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z" fill="var(--color-primary)" />
                    </svg>
                `;
                dateCell.appendChild(pinBadge);

                dateCell.addEventListener('click', () => {
                    if (selectedDateStr === dateStr) {
                        selectedDateStr = null; // Toggle filter off
                    } else {
                        selectedDateStr = dateStr;
                    }
                    renderCalendar();
                    renderEventList();
                });
            }

            calendarDatesElem.appendChild(dateCell);
        }

        // Complete the 6-row grid layout (42 cells total) with leading days of next month
        const totalCells = firstDay + daysInMonth;
        const remainingCells = 42 - totalCells;
        for (let day = 1; day <= remainingCells; day++) {
            const nextCell = document.createElement('div');
            nextCell.className = 'date-cell other-month';
            nextCell.innerHTML = `<span class="date-inner">${day}</span>`;
            calendarDatesElem.appendChild(nextCell);
        }
    }

    // Render Event List (matching theme style and layouts in preview)
    function renderEventList() {
        const container = document.getElementById('eventDetails');
        if (!container) return;

        container.innerHTML = '';

        // Filter events based on selected calendar date
        let filteredEvents = events;
        if (selectedDateStr) {
            filteredEvents = events.filter(ev => {
                return formatDateString(ev.start_datetime) === selectedDateStr;
            });
        }

        // Update list header dynamically with date filter reset action
        const titleHeader = container.parentElement.querySelector('h4.title');
        if (titleHeader) {
            if (selectedDateStr) {
                const formattedDate = new Date(selectedDateStr).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                titleHeader.innerHTML = `Agenda: ${formattedDate} <a href="#" id="resetDateFilter" style="font-size: 12px; margin-left: 10px; color: var(--color-danger); text-decoration: none; font-weight: 500;"><i class="feather-rotate-ccw"></i> Reset</a>`;
                
                // Add click listener to reset filter
                setTimeout(() => {
                    const resetBtn = document.getElementById('resetDateFilter');
                    if (resetBtn) {
                        resetBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            selectedDateStr = null;
                            renderCalendar();
                            renderEventList();
                        });
                    }
                }, 0);
            } else {
                titleHeader.textContent = 'Kegiatan Mendatang';
            }
        }

        if (filteredEvents.length === 0) {
            container.innerHTML = `
                <div class="no-event text-center py-5 text-muted">
                    <i class="feather-calendar" style="font-size: 48px; color: var(--color-border);"></i>
                    <p class="mt--15" style="font-size: 15px;">Tidak ada agenda untuk tanggal ini</p>
                </div>
            `;
            return;
        }

        // Populate event cards
        filteredEvents.forEach(event => {
            // Parse time
            let timeStr = '00:00';
            let dateObj = new Date(event.start_datetime);
            if (!isNaN(dateObj.getTime())) {
                let hours = String(dateObj.getHours()).padStart(2, '0');
                let minutes = String(dateObj.getMinutes()).padStart(2, '0');
                timeStr = `${hours}:${minutes}`;
            }

            const item = document.createElement('div');
            item.className = 'event-item p--15 d-flex gap-3 align-items-center';
            item.style.cssText = 'background: #f8f9fa; border-radius: 8px; border: 1px solid var(--color-border); cursor: pointer; transition: 0.3s;';

            // Hover animations
            item.addEventListener('mouseenter', () => {
                item.style.transform = 'translateY(-2px)';
                item.style.boxShadow = 'var(--shadow-2)';
                item.style.borderColor = 'var(--color-primary)';
            });
            item.addEventListener('mouseleave', () => {
                item.style.transform = 'none';
                item.style.boxShadow = 'none';
                item.style.borderColor = 'var(--color-border)';
            });

            const detailUrl = event.slug ? `/agenda/${event.slug}` : `/agenda`;

            item.addEventListener('click', () => {
                window.location.href = detailUrl;
            });

            item.innerHTML = `
                <div class="event-icon-box d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); width: 46px; height: 46px; border-radius: 8px; flex-shrink: 0;">
                    <i class="feather-calendar" style="color: #fff; font-size: 18px;"></i>
                </div>
                <div style="flex: 1;">
                    <h5 class="rbt-card-title mb--5" style="font-size: 15px; font-weight: 600; line-height: 1.4; margin-bottom: 3px;">
                        <a href="${detailUrl}" style="color: var(--color-heading); text-decoration: none;">${event.title}</a>
                    </h5>
                    <div class="event-meta d-flex gap-3 flex-wrap" style="font-size: 12px; color: var(--color-body);">
                        <span><i class="feather-clock" style="color: var(--color-primary); margin-right: 4px;"></i> ${timeStr} WIB</span>
                        <span><i class="feather-map-pin" style="color: var(--color-primary); margin-right: 4px;"></i> ${event.location || 'TBA'}</span>
                    </div>
                </div>
            `;
            container.appendChild(item);
        });
    }
})();
