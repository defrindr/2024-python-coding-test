<div class="d-flex justify-content-end align-items-center mt-2">
    <div id="time-info" class="alert alert-primary" role="alert">
    </div>
</div>
<div class="row">
    <!-- Embed file section -->
    <div class="col-md-4">
        <embed id="embedPdf" src="" type="application/pdf" width="100%" height="700px">
    </div>
    <!-- Editor section -->
    <div class="col-md-8">
        <!-- Display time taken here -->
        <div>
            <div id="editor" style="height: 500px; width: 100%;"></div>
        </div>
        <div class="mt-2">
            <h4>Output</h4>
            <pre id="output"></pre>
            <pre id="attempts-info"></pre> <!-- Element to display the attempts counter -->
        </div>
    </div>
</div>

{{-- Script required for code editor --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.13/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    const editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/python");
    function initialModul(modul) {
        console.log(modul.file_path)
        document.querySelector('#embedPdf').src = "{{asset('storage/modul/')}}/" + modul.nama
    }
    function initialOutput(result = null) {
        if (!result) return
        document.getElementById("output").textContent =
            "\nCODE STDERR:\n" +
            (result.code_stderr || "No errors") +
            "\n\nUNIT TEST STDOUT:\n" +
            (result.test_stdout || "No output");

        document.getElementById("attempts-info").textContent =
            "\nJumlah Compile: " + result.attempts +
            "\nJumlah Compile Hingga Success: " + result.attempts_to_success +
            "\nPercobaan: " + result.failed_attempts +
            "\nWaktu Selesai Pengerjaan: " + (result.code_passed ? (result.time_taken !== undefined ? result.time_taken : "Belum ada waktu pengerjaan") : "Modul Belum Selesai");

        if (result.code_passed && result.time_taken !== undefined) {
            document.getElementById("time-info").textContent =
                "Waktu Selesai Pengerjaan: " + result.time_taken;
        }
    }
</script>