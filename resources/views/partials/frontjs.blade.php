<script src="https://unpkg.com/alpinejs@3.13.0/dist/cdn.min.js" defer></script>

<script>
function stopsSearch() {
    return {
        stopsBegin: [],
        stopsEnd: [],
        filteredStopsBegin: [],
        filteredStopsEnd: [],
        selectedBeginId: null,
        queryBegin: '',
        queryEnd: '',
        lineData: null,

        fetchStops(option, selectedId = null) {
            let url = '';

            if (option === 'begin') {
                url = '{{ config('app.url') }}/api/stops';
            } else if (option === 'end' && selectedId) {
                url = `{{ config('app.url') }}/api/stopsbyselectedstop/${selectedId}`;
            } else {
                console.error('Niepoprawne wywołanie fetchStops');
                return;
            }

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (option === 'begin') {
                        this.stopsBegin = data;
                    } else if (option === 'end') {
                        this.stopsEnd = data;
                    }
                })
                .catch(err => console.error('Błąd pobierania przystanków:', err));
        },

        filterStops(option) {
            if (option === 'begin') {
                if (this.queryBegin.length === 0) {
                    this.filteredStopsBegin = [];
                    return;
                }
                

                this.filteredStopsBegin = this.stopsBegin.filter(stop => 
                    stop.name.toLowerCase().includes(this.queryBegin.toLowerCase())
                );

                

            } else if (option === 'end') {
                if (this.queryEnd.length === 0) {
                    this.filteredStopsEnd = [];
                    return;
                }

                this.filteredStopsEnd = this.stopsEnd.filter(stop => 
                    stop.name.toLowerCase().includes(this.queryEnd.toLowerCase())
                );
                
            }
        },

        selectStopBegin(stop) {
            this.queryBegin = stop.name;
            this.filteredStopsBegin = [];
            this.selectedBeginId = stop.id;

            this.fetchStops('end', this.selectedBeginId);
        },

        selectStopEnd(stop) {
            this.queryEnd = stop.name;
            this.filteredStopsEnd = [];


            if (this.selectedBeginId && stop.id) {
                const url = `{{ config('app.url') }}/api/getline/${this.selectedBeginId}/${stop.id}`;
                
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                       console.log(data);
                       if (Array.isArray(data) && data.length === 0) {
                            this.lineData = null;
                       } else {
                            this.lineData = data;
                       }
                        
                         
                    })
                    .catch(err => console.error('Błąd pobierania danych linii:', err));
            }
        },
    }
}
</script>