@extends('layouts.master')

@section('main')
<div class="content-wrapper">
  <div class="row">
    <div class="container">
      <div class="d-flex justify-content-end align-items-center mt-2">
        <div id="time-info" class="alert alert-primary" role="alert">
        </div>
      </div>
      <div class="row">
        <!-- Embed file section -->
        <div class="col-md-4">
          <embed src="{{ asset('storage/modul/' . $data->nama) }}" type="application/pdf" width="100%" height="700px">
        </div>
        <!-- Editor section -->
        <div class="col-md-8">
          <!-- Display time taken here -->
          <div>
            <div id="editor" style="height: 500px; width: 100%;">{{ isset($answer) && $answer ? $answer->source : $data->kode_program }}</div>
          </div>
          <div style="display: none">
            <h4>Unit Tests</h4>
            <div id="unitTestsEditor" style="height: 200px; width: 100%;">{{ $data->kunci_jawaban }}</div>
          </div>
          <button id="run-button" class="btn btn-primary mt-3">Run Code</button>
          <button id="save-button" class="btn btn-success mt-3" disabled>Simpan Hasil Pengerjaan</button>
          <div class="mt-2">
            <h4>Output</h4>
            <pre id="output"></pre>
            <pre id="attempts-info"></pre> <!-- Element to display the attempts counter -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Script required for code editor --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.13/ace.js" type="text/javascript" charset="utf-8"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const timeInfoDiv = document.getElementById("time-info");
    const editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/python");

    const unitTestsEditor = ace.edit("unitTestsEditor");
    unitTestsEditor.setTheme("ace/theme/monokai");
    unitTestsEditor.session.setMode("ace/mode/python");

    const modulId = {{ $data->id }}; // Ensure this is correctly passing the modul ID
    const userId = {{ Auth::user()->id }}; // Get the user ID

    let startTime;
    let timer;
    let isCodePassed = false;
    let timeTaken; // Initialize timeTaken variable
    let lastTimeValue = ""; // Variable to store last displayed time    
    let result = <?= isset($answer) && $answer ? $answer -> raw_result : "null" ?>;

    async function fetchTimeTaken() {
      try {
        const response = await fetch(`http://localhost:5000/get-time-taken?modulId=${modulId}&userId=${userId}`);
        const result = await response.json();
        if (response.ok && result.time_taken) {
          updateTimeInfo(result.time_taken); // Update time info initially
        } else {
          hideTimeInfo(); // If no time_taken is returned, hide the time info
        }
      } catch (error) {
        console.error("Failed to fetch time taken:", error);
        hideTimeInfo(); // On error, hide the time info
      }
    }

    function updateTimeInfo(timeText) {
      timeInfoDiv.textContent = "Waktu Pengerjaan: " + timeText;
      lastTimeValue = timeText;
      timeInfoDiv.style.display = "block"; // Ensure time info is visible
    }

    function hideTimeInfo() {
      timeInfoDiv.style.display = "none"; // Hide time info
    }

    function startTimer(waktuTambahan = 0) {
      startTime = (new Date()) - (waktuTambahan * 1000);
      timer = setInterval(updateTimer, 1000); // Update timer every second (1000 ms)
    }

    function stopTimer() {
      const endTime = new Date();
      const timeDiff = endTime - startTime; // in milliseconds
      const seconds = Math.round(timeDiff / 1000);
      return seconds;
    }

    function updateTimer() {
      const currentTime = new Date();
      const timeDiff = currentTime - startTime; // in milliseconds
      const seconds = Math.round(timeDiff / 1000);
      const formattedTime = formatTime(seconds);

      // Only update time info if the time has changed
      if (formattedTime !== lastTimeValue) {
        updateTimeInfo(formattedTime);
      }
    }

    function formatTime(seconds) {
      const minutes = Math.floor(seconds / 60);
      const remainingSeconds = seconds % 60;
      return `${minutes} menit ${remainingSeconds} detik`;
    }

    editor.on('change', function () {
      if (!timer) {
        startTimer(result ? result.raw_time_taken : <?= isset($answer)&&$answer ?$answer->answered_time : 0 ?>);
      }
    });

    document.getElementById("run-button").addEventListener("click", function () {
      runCode(modulId, userId);
    });

    async function runCode(modulId, userId) {
      const code = editor.getValue();
      const unitTests = unitTestsEditor.getValue();

      if (!isCodePassed && timer) {
        timeTaken = stopTimer(); // Calculate time taken before making the request
      }

      try {
        const response = await fetch("http://localhost:5000/run", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ code, unitTests, modulId, userId, timeTaken }), // Include timeTaken in the request body
        });

        result = await response.json();


        fetch("{{ route('siswa.course.save', $data->id) }}", {
          method: "POST",
          headers: {
            accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-Token": "{{csrf_token()}}"
          },
          body: JSON.stringify({
            source: code,
            output: result.code_stdout,
            attempt: result.attempts,
            answered_time: result.raw_time_taken,
            raw_result: JSON.stringify(result)
          })
        })
          .then(res => res.json())
          .then(res => {
            console.log(res)
          }).catch(err => {
            console.log(err)
          })

        if (response.ok) {
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
              "Waktu Selesai Pengerjaan: " + result.time_taken; // Update time taken after successful code pass
            document.querySelector("#save-button").removeAttribute('disabled');
          }


          if (result.code_passed) {
            isCodePassed = false;
            clearInterval(timer); // Stop the timer if code is passed
            updateTimeInfo(result.time_taken); // Update time info after code pass
            timer = null
          }
        } else {
          document.getElementById("output").textContent =
            "Error: " + result.error;
        }
      } catch (error) {
        document.getElementById("output").textContent =
          "Request failed: " + error;
      }
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
          "Waktu Selesai Pengerjaan: " + result.time_taken; // Update time taken after successful code pass
        document.querySelector("#save-button").removeAttribute('disabled');
      }
    }

    document.querySelector("#save-button").addEventListener('click', async () => {
      const code = editor.getValue();
      if (!confirm('Apakah anda yakin ? jawaban yang telah disimpan tidak akan dapat diubah kembali')) return
      try {

        let response = await fetch("{{ route('siswa.course.submit', $data->id) }}", {
          method: "POST",
          headers: {
            accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-Token": "{{csrf_token()}}"
          },
          body: JSON.stringify({
            source: code,
            output: result.code_stdout,
            attempt: result.attempts,
            raw_result: JSON.stringify(result),
            answered_time: result.raw_time_taken
          })
        })
        let json = await response.json()

        alert(json.message)
        if (response.ok) {
          window.location.href = "{{ route('siswa.course.show', $data->sekolah_course_id) }}"
        }
      } catch (error) {
        alert(error.message)
      }
    });


    // Fetch time taken when the page loads
    fetchTimeTaken();
    initialOutput(result)
  });

</script>
@endsection