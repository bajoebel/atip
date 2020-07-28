<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Form</title>
    <style type="text/css">
        #outtable {
            padding: 20px;
            border: 1px solid #e3e3e3;
            width: 100%;
            border-radius: 5px;
        }

        .short {
            width: 50px;
        }

        .normal {
            width: 150px;
        }

        table {
            border-collapse: collapse;
            font-family: arial;
            color: #5E5B5C;
        }

        thead th {
            text-align: left;
            padding: 10px;
        }

        tbody td {
            border-top: 1px solid #e3e3e3;
            padding: 10px;
        }

        tbody tr:nth-child(even) {
            background: #F6F5FA;
        }

        tbody tr:hover {
            background: #EAE9F5
        }
    </style>
</head>

<body>
    <?php
    $head = json_decode($header->form_field);
    ?>
    <h1>Laporan <?= $header->form_title ?></h1>
    <table id="outtable">
        <thead class="bg-green">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <?php
                foreach ($head as $h) {
                    echo "<th>" . $h->alias . "</th>";
                    $val[] = $h->field;
                }
                if ($header->form_lampiran != "" || $header->form_lampiran != null) {
                    echo "<th>" . $header->form_lampiran . "</th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>

            <?php
            $start = 0;
            foreach ($data_form as $row) {
                $res = json_decode($row->isi_baris);
                $start++;
            ?>
                <tr>
                    <td><?= $start ?></td>
                    <td><?= $row->isi_tanggal ?></td>
                    <?php
                    //print_r($val);
                    foreach ($val as $v) {
                        echo "<td>" . $res->$v . "</td>";
                    }
                    if ($header->form_lampiran != "" || $header->form_lampiran != null) {
                        if (empty($row->isi_lampiran)) echo "<td>Tidak Ada Lampiran</td>";
                        else {
                            echo "<td><a href='" . base_url() . "uploads/lampiran/" . $row->isi_lampiran . "' class='btn btn-success btn-xs' target='_blank'><span class='fa fa-search'></span> ". $row->isi_lampiran ."</a></td>";
                        }
                    }
                    ?>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <script>
        window.print();
    </script>
</body>

</html>