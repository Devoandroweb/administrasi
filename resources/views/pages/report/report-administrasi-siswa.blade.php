<table>
    <thead>
    <tr style="font-weight: bold">
        <th style="font-weight: bold; background:rosybrown">NIS</th>
        <th style="font-weight: bold; background:rosybrown;">Nama</th>
        <th style="font-weight: bold; background:rosybrown;">Kelas</th>
        @foreach($ajarans as $ajaran)
        <th colspan="2" style="font-weight: bold;text-align:center; background:aquamarine;">{{$ajaran['tahun_awal']."/".$ajaran['tahun_akhir']}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @php $ajaranSession = Session::get('tahun_awal')." - ".Session::get('tahun_akhir'); @endphp
    @foreach($siswas as $siswa)
        @if(count($siswa->admSiswa) != 0 || count($siswa->tunggakan) != 0)
        <tr >
            <td style="background:darkkhaki">{{ $siswa->nis }}</td>
            <td style="background:darkkhaki">{{ $siswa->nama }}</td>
            <td style="background:darkkhaki">{{ $siswa->kelas->nama." ".$siswa->kelas->jurusan->nama }}</td>
            @foreach($ajarans as $ajaran)
            <td style="text-align:center;background:salmon;"><i>Biaya</i></td>
            <td style="text-align:center;background:salmon;"><i>Nominal</i></td>
            @endforeach
        </tr>
        @endif
        @php $no = 1; $adm = ""; @endphp
        
        @foreach($ajarans as $ajaran)
        @php
        $textAjaran = $ajaran['tahun_awal']." - ".$ajaran['tahun_akhir'];
        foreach ($siswa->admSiswa as $adm_siswa) {
            if($ajaranSession == $textAjaran){
                // dd($adm_siswa->jenisAdministrasi);
                $adm .= "<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>".$adm_siswa->jenisAdministrasi->nama."</td>
                    <td>".$adm_siswa->nominal."</td>@C".$no."
                </tr>";
                // $no++;
            }
            $no++;
        }

        $noa = 1;
        $data = $siswa->tunggakan;
        foreach ($siswa->tunggakan as $tgg_siswa) {
            if($textAjaran == $tgg_siswa->ajaran){
                $tTunggakan = "<td>".$tgg_siswa->nama_tunggakan."</td><td>".$tgg_siswa->nominal."</td>";
                $adm = str_replace("@C".$noa,$tTunggakan,$adm);
            }
            $noa++;
        }

        @endphp
        @endforeach
        <?= $adm ?>
    @endforeach
    </tbody>
</table>

