<h3>Voted IPs for Poll #{{ $pollId }}</h3>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<table border="1" cellpadding="5">
    <tr>
        <th>IP Address</th>
        <th>Option ID</th>
        <th>Action</th>
    </tr>

    @foreach($ips as $row)
        <tr>
            <td>{{ $row->ip_address }}</td>
            <td>{{ $row->poll_option_id }}</td>
            <td>
                <form method="POST" action="/admin/release-ip">
                    @csrf
                    <input type="hidden" name="poll_id" value="{{ $pollId }}">
                    <input type="hidden" name="ip_address" value="{{ $row->ip_address }}">
                    <button type="submit">Release</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
