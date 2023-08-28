<script>
    let img = null;
    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    var myDropzone = new Dropzone(document.body, {
        // Make the whole body a dropzone
        url: "<?= $_SESSION['path'] ?>/func/updateEmployee.php", // Set the url
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 1,
        maxFiles: 1,
        uploadMultiple: false,
        acceptedFiles: "image/jpeg, image/jpg, image/png",
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
        init: function() {
            this.on("addedfile", function(file) {
                if (this.files.length > 1) {
                    // Si hay más de un archivo en la cola, eliminamos el anterior
                    this.removeFile(this.files[0]);
                }
            });
            img = this.files[0]
        },
    });

    myDropzone.on("addedfile", (file) => {
        img = file;
    });
    myDropzone.on("removedfile", (file) => {
        img = null;
    });

    document.getElementById('updateEmployee').addEventListener('click', (e) => {
        let imgData = new FormData();
        imgData.append('file', img)

        fetch('<?= $_SESSION['path'] ?>/func/updateEmployee.php', {
            method: 'POST',
            body: imgData
        })
    })
</script>