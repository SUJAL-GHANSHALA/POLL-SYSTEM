<h1>Active Polls</h1>

@if($polls->isEmpty())
    <p>No active polls found.</p>
@endif

@foreach($polls as $poll)
    <div style="margin-bottom:10px;">
        <a href="#" class="poll-link" data-id="{{ $poll->id }}">
            {{ $poll->question }}
        </a>
    </div>
@endforeach

<div id="poll-area" style="margin-top:20px;"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){
    $('.poll-link').click(function(e){
        e.preventDefault();
        let id = $(this).data('id');

        $('#poll-area').load('/polls/' + id);
    });
});
</script>
