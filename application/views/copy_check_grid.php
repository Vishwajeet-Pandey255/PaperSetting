<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Copy Checking - Grid</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body{ font-family: Arial, sans-serif; margin:18px; }
    .top-center {
      text-align:center;
      margin-bottom:14px;
      padding:10px 14px;
      border:1px solid #e0e0e0;
      border-radius:6px;
      min-height:70px;
      background:#fafafa;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }
    .container { display:flex; gap:16px; align-items:flex-start; }
    .left { flex:1; min-width:60%; }
    .right { width:420px; }
    iframe.pdf-view{ width:100%; height:720px; border:1px solid #ccc; border-radius:6px; }
    .grid {
      display:grid;
      grid-template-columns: repeat(3, 1fr);
      gap:8px;
      margin-bottom:12px;
    }
    .qcard {
      border:1px solid #eee;
      padding:10px;
      border-radius:6px;
      display:flex;
      align-items:center;
      gap:8px;
      background:#fff;
      cursor:pointer;
    }
    .qnum { width:40px; font-weight:700; text-align:center; }
    .qtitle { font-size:13px; color:#333; flex:1; }
    .controls {
      border-top:1px solid #eee;
      padding-top:12px;
      margin-top:8px;
      display:flex;
      gap:10px;
      align-items:center;
    }
    .controls input[type="number"]{ width:110px; padding:8px; border:1px solid #ddd; border-radius:4px; }
    .save-btn { padding:8px 12px; border:0; background:#1976d2; color:#fff; border-radius:4px; cursor:pointer; }
    .save-btn[disabled]{ background:#aaa; cursor:default; }
    .muted{ color:#666; font-size:13px; }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<h1>Copy Checking</h1>

<div class="top-center" id="questionDisplay">
  <div id="questionHeading" style="font-weight:700; font-size:18px; margin-bottom:6px;">Select a question</div>
  <div id="questionContent" style="font-size:14px; color:#222;"></div>
</div>

<div class="container">
  <div class="left">
    <h3>Answer Sheet</h3>
    <iframe class="pdf-view" src="<?= $pdf_path ?>"></iframe>
  </div>

  <div class="right">
    <h3>Marking Scheme</h3>

    <div class="grid" id="questionsGrid">
      <?php foreach($questions as $q): ?>
        <div class="qcard" data-qid="<?= $q->id ?>" onclick="selectQuestion(<?= $q->id ?>, this)">
          <div class="qnum"></div>
          <div class="qtitle"><?= htmlspecialchars($q->title ? $q->title : 'Question '.$q->q_no) ?></div>
          <div style="width:18px;">
            <input type="checkbox" class="qcheck" id="chk_<?= $q->id ?>" />
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- single control area shown only when a question selected -->
    <div id="singleControls" style="display:none;">
      <div class="muted">Selected Question: <span id="selQno"></span></div>
      <div class="controls">
        <div>
          <label>Out of</label><br>
          <input type="number" id="out_of" readonly />
        </div>
        <div>
          <label>Marks given</label><br>
          <input type="number" id="marks_given" min="0" />
        </div>
        <div>
          <label>&nbsp;</label><br>
          <button class="save-btn" id="saveBtn" disabled>Save</button>
        </div>
      </div>
      <div id="saveStatus" style="margin-top:8px; color:green; display:none;">Saved ✓</div>
    </div>

  </div>
</div>

<script>
  // student id passed from controller (may be null)
  var student_id = <?= isset($student_id) && $student_id ? intval($student_id) : 0 ?>;
  var selected_qid = 0;
  var selected_max = 0;

  function clearAllChecks(){
    $('.qcheck').prop('checked', false);
    $('.qcard').removeClass('active');
  }

  // select question either via click on card or checkbox
  function selectQuestion(qid, el){
    // uncheck all others (single selection)
    clearAllChecks();
    $(el).find('.qcheck').prop('checked', true);
    $(el).addClass('active');

    // fetch question content from server (AJAX)
    $.get("<?= site_url('copycheck/get_question_content') ?>", { question_id: qid }, function(resp){
      if(resp.status === 'ok'){
        $('#questionHeading').text('Q' + resp.question.q_no + ': ' + (resp.question.title || ''));
        $('#questionContent').html(resp.question.content || resp.question.title || '');
        selected_qid = resp.question.id;
        selected_max = resp.question.max_marks;
        $('#out_of').val(selected_max);
        $('#marks_given').val('');
        $('#saveBtn').prop('disabled', true);
        $('#saveStatus').hide();
        $('#singleControls').show();
      } else {
        alert('Error: ' + resp.message);
      }
    }, 'json').fail(function(){ alert('Failed to load question content'); });
  }

  // clicking directly on checkbox should also trigger select
  $(document).on('change', '.qcheck', function(){
    if($(this).is(':checked')){
      var card = $(this).closest('.qcard');
      selectQuestion(card.data('qid'), card[0]);
    } else {
      // if unchecked, hide controls
      $('#singleControls').hide();
      $('#questionHeading').text('Select a question');
      $('#questionContent').html('');
      selected_qid = 0;
      selected_max = 0;
    }
  });

  // validate marks input to enable save
  $('#marks_given').on('input', function(){
    var v = $(this).val();
    if(v === '') { $('#saveBtn').prop('disabled', true); return; }
    var n = parseFloat(v);
    if(isNaN(n) || n < 0 || n > selected_max) {
      $('#saveBtn').prop('disabled', true);
    } else {
      $('#saveBtn').prop('disabled', false);
    }
  });

  // save via AJAX
  $('#saveBtn').on('click', function(e){
    e.preventDefault();
    if(!selected_qid){
      alert('Select a question first.');
      return;
    }
    if(!student_id){
      alert('No student set. Open the page with ?student_roll=ROLL in the URL (we create a student record automatically).');
      return;
    }
    var marks = parseInt($('#marks_given').val());
    var btn = $(this);
    btn.prop('disabled', true).text('Saving...');

    $.post("<?= site_url('copycheck/save_question_marks') ?>", {
      student_id: student_id,
      question_id: selected_qid,
      marks: marks
    }, function(resp){
      btn.prop('disabled', false).text('Save');
      if(resp.status === 'ok'){
        $('#saveStatus').show().text('Saved ✓');
      } else {
        alert('Error: '+resp.message);
      }
    }, 'json').fail(function(){
      btn.prop('disabled', false).text('Save');
      alert('Request failed; try again.');
    });
  });
</script>

</body>
</html>
