<h3>{{ $poll->question }}</h3>

<form id="voteForm">
    @foreach($options as $option)
        <div>
            <input type="radio" name="option_id" value="{{ $option->id }}" required>
            {{ $option->option_text }}
        </div>
    @endforeach

    <input type="hidden" name="poll_id" value="{{ $poll->id }}">
    <button type="submit">Vote</button>
</form>

<div id="vote-message" style="margin-top:10px;color:green;"></div>

<hr>
<h4>Live Results</h4>
<div id="results"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    $('#voteForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '/vote',
            method: 'POST',
            data: $(this).serialize(),
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function(res) {
                $('#vote-message').text(res.message);
                loadResults();
            },
            error: function() {
                $('#vote-message').text('Error submitting vote');
            }
        });
    });

    function loadResults() {
        $.get('/poll/{{ $poll->id }}/results', function(data){
            let html = '';
            data.forEach(function(row){
                html += `<p>${row.option_text}: ${row.total_votes}</p>`;
            });
            $('#results').html(html);
        });
    }

    loadResults();

    setInterval(loadResults, 1000);
});
</script>
