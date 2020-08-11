function handleFileSelect (evt) {
    let file = evt.target.files;
    let f = file[0];

    if (!f.type.match('image.*')) {
        alert ('There is only image, please');
    }

    let fr = new FileReader ();

    fr.onload = (function(theFile) {
        return function(e) {
            let span = document.createElement('span');
            span.innerHTML = ['<img class="thumb" title="', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
            document.getElementById('outputImage').insertBefore(span, null);
        };
    })(f);
    fr.readAsDataURL(f);
}

document.getElementById('downloadFile').addEventListener('change', handleFileSelect, false);


const downloadButton = document.getElementById('downloadAdminFile');
const imageArea = document.getElementById('outputAdminImage');


    downloadButton.addEventListener('change', function() {
        imageArea.innerHTML = '';

        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.addEventListener('load', function() {
                let img = document.createElement('img');
                img.classList.add('thumb');
                img.src = this.result;
                imageArea.append(img);
            });

            reader.readAsDataURL(file);
        };
    });