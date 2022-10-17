const fileSelect = document.getElementById("fileSelect"),
            file = document.getElementById("file"),
            fileDisplay = document.getElementById("fileDisplay");

    fileSelect.addEventListener("click", function (e) {
    if (file) {
        file.click();
    }
    e.preventDefault(); // prevent navigation to "#"
    }, false);

    file.addEventListener("change", handleFiles, false);

    function handleFiles() {
    var tombol = document.getElementById('tombol');
    tombol.style.display = "inline";
    if (!this.files.length) {
        fileDisplay.innerHTML = "<p>No files selected!</p>";
    } else {
            fileDisplay.innerHTML = "";
            const div = document.createElement("div");
            fileDisplay.appendChild(div);
            for (let i = 0; i < this.files.length; i++) {
                const img = document.createElement("img");
                img.src = URL.createObjectURL(this.files[i]);
                img.width = 200;
                img.id = "source";
                div.appendChild(img);
                const br1 = document.createElement("br");
                const br2 = document.createElement("br");
                const br3 = document.createElement("br");
                const info1 = document.createElement("span");
                info1.id = "nama";
                info1.innerHTML = 'Nama Logo : ' + this.files[i].name;
                const info2 = document.createElement("span");
                info2.id = "ukuran";
                info2.innerHTML = 'Ukuran Logo : ' + this.files[i].size + " bytes";
                div.appendChild(br1);
                div.appendChild(info1);
                div.appendChild(br2);
                div.appendChild(info2);
                div.appendChild(br3);
            }
    }
    }

    var tombol = document.getElementById('tombol');
    tombol.addEventListener('click', function (e) {
        var fileDisplay = document.getElementById("fileDisplay");
        var tombol = document.getElementById('tombol');

        tombol.style.display = "none";
        fileDisplay.innerHTML = "<p>Logo Belum Dipilih</p>";
        e.preventDefault(); 
    }, false);