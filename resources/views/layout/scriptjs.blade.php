<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

{{-- <script src="./assets/vendor/lodash/lodash.min.js"></script>
<script src="./assets/vendor/dropzone/dist/dropzone-min.js"></script> --}}

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>

<script>
    window.addEventListener('load', () => {
       

        const inputs = document.querySelectorAll('.dt-container thead input');

        inputs.forEach((input) => {
            input.addEventListener('keydown', function(evt) {
                if ((evt.metaKey || evt.ctrlKey) && evt.key === 'a') this.select();
            });
        });
    });
</script>
