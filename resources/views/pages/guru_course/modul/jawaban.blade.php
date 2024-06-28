@extends('layouts.master')

@section('main')
<div class="content-wrapper">
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <embed src="{{ asset('storage/modul/' . $data->nama) }}" type="application/pdf" width="100%" height="700px">
        </div>
        <div class="col-md-8">
          <div class="title">Kode Program</div>
          <div class="code-editor-wrapper">
              <div id="editor" style="height: 300px; width: 100%;">{{ $data->kode_program }}</div>
          </div>
          <div class="mt-2">
              <h4>Unit Tests</h4>
              <div id="unitTestsEditor" style="height: 300px; width: 100%;">{{ $data->kunci_jawaban }}</div>
          </div>
          <button id="run-button" class="btn btn-primary mt-3">Run Code</button>
          <button id="save-button" class="btn btn-success mt-3">Simpan Kunci Jawaban</button>
          <div class="mt-2">
              <h4>Output</h4>
              <pre id="output"></pre>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Script required for code editor --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.13/ace.js" type="text/javascript" charset="utf-8"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const editor = ace.edit("editor");
  editor.setTheme("ace/theme/monokai");
  editor.session.setMode("ace/mode/python");

  const unitTestsEditor = ace.edit("unitTestsEditor");
  unitTestsEditor.setTheme("ace/theme/monokai");
  unitTestsEditor.session.setMode("ace/mode/python");

  document.getElementById("save-button").addEventListener("click", async function() {
    const unitTests = unitTestsEditor.getValue();
    const kodeProgram = editor.getValue();
    const modulId = {{ $data->id }};  // Replace with the actual modul ID

    $.ajax({
      url: `/python-jawaban/${modulId}`,
      type: "PUT",
      headers: {
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
      },
      contentType: "application/json",
      data: JSON.stringify({ kunci_jawaban: unitTests, kode_program: kodeProgram }),
      success: function(response) {
        alert(response.message || "Kunci jawaban berhasil disimpan!");
      },
      error: function(xhr, status, error) {
        alert("Error: " + (xhr.responseJSON.message || "An error occurred"));
      }
    });
  });

  document.getElementById("run-button").addEventListener("click", runCode);

  async function runCode() {
    const code = editor.getValue();
    const unitTests = unitTestsEditor.getValue();

    try {
      const response = await fetch("http://localhost:5000/run-guru", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ code, unitTests }),
      });

      const result = await response.json();

      if (response.ok) {
        document.getElementById("output").textContent =
          "\nUNIT TEST STDOUT:\n" +
          (result.test_stdout || "No output") +
          "\nUNIT TEST STDERR:\n" +
          (result.test_stderr || "No errors");
      } else {
        document.getElementById("output").textContent =
          "Error: " + result.error;
      }
    } catch (error) {
      document.getElementById("output").textContent =
        "Fetch Error: " + error.message;
    }
  }
});
</script>

<style>
  .title {
    font-size: 24px;
    /* font-weight: bold; */
    padding: 2px 0;
  }
  .code-editor-wrapper {
    margin-top: 15px;
  }
</style>

@endsection
