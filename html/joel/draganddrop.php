<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    #filedrag {
        display: none;
        font-weight: bold;
        text-align: center;
        padding: 1em 0;
        margin: 1em 0;
        color: #555;
        border: 2px dashed #555;
        border-radius: 7px;
        cursor: default;
    }

    #filedrag.hover {
        color: #f00;
        border-color: #f00;
        border-style: solid;
        box-shadow: inset 0 3px 4px #888;
    }
</style>
<script>
    // getElementById
    function $id(id) {
        return document.getElementById(id);
    }

    //
    // output information
    function Output(msg) {
        var m = $id("messages");
        m.innerHTML = msg + m.innerHTML;
    }
    // call initialization file
    if (window.File && window.FileList && window.FileReader) {
        Init();
    }

    //
    // initialize
    function Init() {

        var fileselect = $id("fileselect"),
            filedrag = $id("filedrag"),
            submitbutton = $id("submitbutton");

        // file select
        fileselect.addEventListener("change", FileSelectHandler, false);

        // is XHR2 available?
        var xhr = new XMLHttpRequest();
        if (xhr.upload) {

            // file drop
            filedrag.addEventListener("dragover", FileDragHover, false);
            filedrag.addEventListener("dragleave", FileDragHover, false);
            filedrag.addEventListener("drop", FileSelectHandler, false);
            filedrag.style.display = "block";

            // remove submit button
            submitbutton.style.display = "none";
        }

    }
    // file drag hover
    function FileDragHover(e) {
        e.stopPropagation();
        e.preventDefault();
        e.target.className = (e.type == "dragover" ? "hover" : "");
    }

    // file selection
    function FileSelectHandler(e) {

        // cancel event and hover styling
        FileDragHover(e);

        // fetch FileList object
        var files = e.target.files || e.dataTransfer.files;

        // process all File objects
        for (var i = 0, f; f = files[i]; i++) {
            ParseFile(f);
        }

    }

    function ParseFile(file) {

        Output(
            "<p>File information: <strong>" + file.name +
            "</strong> type: <strong>" + file.type +
            "</strong> size: <strong>" + file.size +
            "</strong> bytes</p>"
        );

    }
</script>

<body>
    <form id="upload" action="upload.php" method="POST" enctype="multipart/form-data">

        <fieldset>
            <legend>HTML File Upload</legend>

            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="300000" />

            <div>
                <label for="fileselect">Files to upload:</label>
                <input type="file" id="fileselect" name="fileselect[]" multiple="multiple" />
                <div id="filedrag">or drop files here</div>
            </div>

            <div id="submitbutton">
                <button type="submit">Upload Files</button>
            </div>

        </fieldset>

    </form>

    <div id="messages">
        <p>Status Messages</p>
    </div>

</body>

</html>