<table class="">
    <thead>
        <tr>
            <th class="">Tanggal Ibadah</th>
            <th class="">Nama Ibadah</th>
            <th class="">Topik Ibadah</th>
            <th class="">Pembawa Ibadah</th>
            <th class="">Jemaat</th>
            <th class="">Pengajaran</th>
            <th class="">Usher</th>
            <th class="">Pemusik</th>
            <th class="">Audio Visual</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ \Carbon\Carbon::parse($ibadah->tanggal)->translatedFormat('j F Y')  }}</td>
            <td>{{ $ibadah->nama }}</td>
            <td>{{ $ibadah->topik }}</td>
            <td>{{ $ibadah->pembawa }}</td>
            <td>
                @foreach($ibadah->users as $user)
                    {{ $user->username }} <br>
                @endforeach
            </td>
            <td>
                @foreach($ibadah->pengajarans as $pengajaran)
                    {{ $pengajaran->topik }} <br>
                @endforeach
            </td>
            <td>
                @foreach($ibadah->ushers as $usher)
                    {{ $usher->user->username }} <br>
                @endforeach
            </td>
            <td>
                @foreach($ibadah->pemusiks as $pemusik)
                    {{ $pemusik->user->username }} <br>
                @endforeach
            </td>
            <td>
                @foreach($ibadah->avls as $avl)
                    {{ $avl->user->username }} <br>
                @endforeach
            </td>
            <!-- Add other data fields as needed -->
        </tr>
    </tbody>
</table>
