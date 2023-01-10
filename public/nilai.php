<?php 
error_reporting(0);
include_once 'navbar.php';
include_once '../app/config.php';
if(date('m') < 7){
    $thn=date('Y')-1;
    $smt=1;  
}else{
    $thn=date('Y')-1;
    $smt=2;
}
$yth=$thn-1;
?>
<style>
	.form-signin {
	width: 100%;
	max-width: 330px;
	padding: 15px;
	margin: auto;
	}
</style>
<main class="content">
	<div class="container">
	<p class="display-6 text-center mb-2">Penilaian</p>
	<p class="h5 text-center mb-3">Periode <?= $thn . '-' . intval($thn+1) ?></p>
    
    <?php 
		if(!isset($_POST['nis'])){
    ?>
    <div class="form-signin text-center mt-5">  
		<form action="" method="post">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><span data-feather="user"></span></span>
                <input type="text" name="nis" class="form-control" placeholder="Nomor Induk" autocomplete="off">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><span data-feather="calendar"></span></span>
                <input type="text" name="tgl" id="tgl" class="form-control" placeholder="Tgl Lahir" aria-label="Username" autocomplete="off">
            </div>
			<button class="btn btn-lg btn-dark mt-2" type="submit">Masuk</button>
		</form>
	</div>
    <?php 
    }else{
        $nis=$_POST['nis'];
        $tgl=$_POST['tgl'];
        $santri=myquery("SELECT * FROM santri WHERE nis='$nis' AND tgl_lahir='$tgl'");
        if(!$santri){
            echo '<h3 class="text-center text-danger mt-5">.. Tidak ada Data ..</h3>';
        }else{
            $san=$santri[0];
            $nis=$san['nis'];
            // QUERY NILAI TAHUN INI
            $pro=myquery("SELECT DISTINCT thn, SUM(angka) as sum, COUNT(*) as con FROM `nilai` WHERE nis='$nis' GROUP BY thn");
            $sum=myquery("SELECT SUM(IF(left(materi, 4)='1.1.', angka, 0)) as '11', 
                                 SUM(IF(left(materi, 4)='1.2.', angka, 0)) as '12', 
                                 SUM(IF(left(materi, 4)='1.3.', angka, 0)) as '13', 
                                 SUM(IF(left(materi, 4)='1.4.', angka, 0)) as '14', 
                                 SUM(IF(left(materi, 4)='1.5.', angka, 0)) as '15', 
                                 SUM(IF(left(materi, 4)='1.6.', angka, 0)) as '16', 
                                 SUM(IF(left(materi, 4)='2.1.', angka, 0)) as '21', 
                                 SUM(IF(left(materi, 4)='2.2.', angka, 0)) as '22', 
                                 SUM(IF(left(materi, 4)='2.3.', angka, 0)) as '23', 
                                 SUM(IF(left(materi, 4)='2.4.', angka, 0)) as '24', 
                                 SUM(IF(left(materi, 4)='2.5.', angka, 0)) as '25', 
                                 SUM(IF(left(materi, 4)='2.6.', angka, 0)) as '26', 
                                 SUM(IF(left(materi, 4)='3.1.', angka, 0)) as '31',     
                                 SUM(IF(left(materi, 4)='3.2.', angka, 0)) as '32', 
                                 SUM(IF(left(materi, 4)='3.3.', angka, 0)) as '33', 
                                 SUM(IF(left(materi, 4)='3.4.', angka, 0)) as '34', 
                                 SUM(IF(left(materi, 4)='3.5.', angka, 0)) as '35', 
                                 SUM(IF(left(materi, 4)='3.6.', angka, 0)) as '36' 
                                 FROM nilai WHERE nis='$nis' AND thn='$thn'");
            $s = $sum[0];
            $iman = (($s['11']/$smt)+($s['12']/$smt)) /2 ;
            $quran = (($s['13']/$smt)+($s['14']/$smt)+($s['15']/$smt)+($s['16']/$smt)) /4 ;
            $murof = (($s['21']/$smt)+($s['22']/$smt)+($s['23']/$smt)+($s['24']/$smt)+($s['25']/$smt)+($s['26']/$smt)) /6 ;
            $penj = (($s['31']/$smt)+($s['32']/$smt)+($s['33']/$smt)+($s['34']/$smt)+($s['35']/$smt)+($s['36']/$smt)) /6 ;
            // QUERY NILAI TAHUN LALU
            $prev=myquery("SELECT SUM(IF(left(materi, 4)='1.1.', angka, 0)) as '11', 
                                 SUM(IF(left(materi, 4)='1.2.', angka, 0)) as '12', 
                                 SUM(IF(left(materi, 4)='1.3.', angka, 0)) as '13', 
                                 SUM(IF(left(materi, 4)='1.4.', angka, 0)) as '14', 
                                 SUM(IF(left(materi, 4)='1.5.', angka, 0)) as '15', 
                                 SUM(IF(left(materi, 4)='1.6.', angka, 0)) as '16', 
                                 SUM(IF(left(materi, 4)='2.1.', angka, 0)) as '21', 
                                 SUM(IF(left(materi, 4)='2.2.', angka, 0)) as '22', 
                                 SUM(IF(left(materi, 4)='2.3.', angka, 0)) as '23', 
                                 SUM(IF(left(materi, 4)='2.4.', angka, 0)) as '24', 
                                 SUM(IF(left(materi, 4)='2.5.', angka, 0)) as '25', 
                                 SUM(IF(left(materi, 4)='2.6.', angka, 0)) as '26', 
                                 SUM(IF(left(materi, 4)='3.1.', angka, 0)) as '31',     
                                 SUM(IF(left(materi, 4)='3.2.', angka, 0)) as '32', 
                                 SUM(IF(left(materi, 4)='3.3.', angka, 0)) as '33', 
                                 SUM(IF(left(materi, 4)='3.4.', angka, 0)) as '34', 
                                 SUM(IF(left(materi, 4)='3.5.', angka, 0)) as '35', 
                                 SUM(IF(left(materi, 4)='3.6.', angka, 0)) as '36' 
                                 FROM nilai WHERE nis='$nis' AND thn='$yth'");
            $p = $prev[0];
            $iman_p = (($p['11']/2)+($p['12']/2)) /2 ;
            $quran_p = (($p['13']/2)+($p['14']/2)+($p['15']/2)+($p['16']/2)) /4 ;
            $murof_p = (($p['21']/2)+($p['22']/2)+($p['23']/2)+($p['24']/2)+($p['25']/2)+($p['26']/2)) /6 ;
            $penj_p = (($p['31']/2)+($p['32']/2)+($p['33']/2)+($p['34']/2)+($p['35']/2)+($p['36']/2)) /6 ;
            // PERSENTASI KENAIKAN
            $iman_g = ($iman-$iman_p) /$iman_p *100 ;
            $quran_g = ($quran-$quran_p) /$quran_p *100 ;
            $murof_g = ($murof-$murof_p) /$murof_p *100 ;
            $penj_g = ($penj-$penj_p) /$penj_p *100 ;
    ?>
	<div class="text-center">
        <a href="nilai" class="btn btn-lg btn-dark mt-2">Keluar</a>
        <h3 class="text-center mb-3 mt-4"><?= $nis . ' - ' . $san['nama'] ?></h3>
    </div>

    <div class="row">
        <div class="col-xl-6 col-xxl-7">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Progress</h5>
                </div>
                <div class="card-body py-3">
                    <div class="chart chart-sm">
                        <canvas id="progres"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-xxl-5 d-flex">
            <div class="w-100">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Iman</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="compass"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3"><?= round($iman,2) ?></h1>
                                <div class="mb-0">
                                    <span class="text-small <?= $iman_g < 0 ? 'text-danger' : 'text-primary' ?>"> <i class="mdi mdi-arrow-bottom-right"></i><span data-feather="<?= $iman_g < 0 ? 'trending-down' : 'trending-up' ?>"></span> <?= round($iman_g,2) ?>% dari sebelumnya</span>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Murofaqot</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="book-open"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3"><?= round($murof,2) ?></h1>
                                <div class="mb-0">
                                    <span class="text-small <?= $murof_g < 0 ? 'text-danger' : 'text-primary' ?>"> <i class="mdi mdi-arrow-bottom-right"></i><span data-feather="<?= $murof_g < 0 ? 'trending-down' : 'trending-up' ?>"></span> <?= round($murof_g,2) ?>% dari sebelumnya</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Alquran</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="book"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3"><?= round($quran,2) ?></h1>
                                <div class="mb-0">
                                    <span class="text-small <?= $quran_g < 0 ? 'text-danger' : 'text-primary' ?>"> <i class="mdi mdi-arrow-bottom-right"></i><span data-feather="<?= $quran_g < 0 ? 'trending-down' : 'trending-up' ?>"></span> <?= round($quran_g,2) ?>% dari sebelumnya</span>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Penunjang</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="briefcase"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3"><?= round($penj,2) ?></h1>
                                <div class="mb-0">
                                    <span class="text-small <?= $penj_g < 0 ? 'text-danger' : 'text-primary' ?>"> <i class="mdi mdi-arrow-bottom-right"></i><span data-feather="<?= $penj_g < 0 ? 'trending-down' : 'trending-up' ?>"></span> <?= round($penj_g,2) ?>% dari sebelumnya</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="text-center mb-3">Muatan Khusus</h4>
    <div class="row">
        <div class="col-12 col-md-5 col-xl-4 d-flex order-1 order-xxl-1">
            <div class="card flex-fill">
                <div class="card-header">
                    <h5 class="card-title mb-0">Iman & Alquran</h5>
                </div>
                <div class="card-body d-flex">
                    <div class="align-self-center w-100">
                        <div class="py-3">
                            <div class="chart chart-xs">
                                <canvas id="imanQuran"></canvas>
                            </div>
                        </div>
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td>Nilai Iman</td>
                                    <td class="text-end"><?= round($iman,2) ?></td>
                                </tr>
                                <tr>
                                    <td>Nilai Alquran</td>
                                    <td class="text-end"><?= round($quran,2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-7 col-xl-8 col-xxl-3 d-flex order-2 order-xxl-2">
            <div class="card flex-fill">
                <div class="card-header">
                    <h5 class="card-title mb-0">Alquran</h5>
                </div>
                <div class="card-body d-flex">
                    <div class="align-self-center w-100">
                        <div class="chart">
                            <canvas id="quranDetail"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-5 col-xl-4 d-flex order-1 order-xxl-1">
            <div class="card flex-fill">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pemahaman & Sikap</h5>
                </div>
                <div class="card-body d-flex">
                    <div class="align-self-center w-100">
                        <div class="py-3">
                            <div class="chart chart-xs">
                                <canvas id="pahamSikap"></canvas>
                            </div>
                        </div>
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td>Nilai Pemahaman</td>
                                    <td class="text-end"><?= round(($s['11']/$smt),2) ?></td>
                                </tr>
                                <tr>
                                    <td>Nilai Sikap</td>
                                    <td class="text-end"><?= round(($s['12']/$smt),2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-7 col-xl-8 d-flex order-2 order-xxl-2">
            <div class="card flex-fill">
                <div class="card-header">

                    <h5 class="card-title mb-0">Murofaqot</h5>
                </div>
                <div class="card-body d-flex">
                    <div class="align-self-center w-100">
                        <div class="chart">
                            <canvas id="murofaqot"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<h6 class="mb-3 text-center text-muted">Tekan tombol Keluar jika sudah selasai.. <span data-feather="smile"></span></h6>
</main>
<?php
    }
}
?>

<script>
// GRAFIK PROGRES NILAI RATA-RATA
document.addEventListener("DOMContentLoaded", function() {
    // document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById("progres").getContext("2d");
    var gradient = ctx.createLinearGradient(0, 0, 0, 225);
    gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
    gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
    // Line chart
    new Chart(document.getElementById("progres"), {
        type: "line",
        data: {
            labels: [
                <?php 
                foreach($pro as $p) :
                    echo '"' . $p['thn'] . '", ';
                endforeach; 
                ?> 
            ],
            datasets: [{
                label: "Rata-rata",
                fill: true,
                backgroundColor: gradient,
                borderColor: window.theme.primary,
                data: [
                    <?php 
                    foreach($pro as $p) :
                        $avg = $p['sum'] / $p['con'];
                        echo round($avg,2) . ', ';
                    endforeach; 
                    ?> 
                ]
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            tooltips: {
                intersect: false
            },
            hover: {
                intersect: true
            },
            plugins: {
                filler: {
                    propagate: false
                }
            },
            scales: {
                xAxes: [{
                    reverse: true,
                    gridLines: {
                        color: "rgba(0,0,0,0.0)"
                    }
                }],
                yAxes: [{
                    ticks: {
                        stepSize: 1000
                    },
                    display: true,
                    borderDash: [3, 3],
                    gridLines: {
                        color: "rgba(0,0,0,0.0)"
                    }
                }]
            }
        }
    });
});
// GRAFIK IMAN & ALQURAN
document.addEventListener("DOMContentLoaded", function() {
    // Pie chart
    new Chart(document.getElementById("imanQuran"), {
        type: "pie",
        data: {
            labels: ["Iman", "Alquran"],
            datasets: [{
                data: [
                    <?= round($iman,2) ?>, 
                    <?= round($quran,2) ?>
                ],
                backgroundColor: [
                    window.theme.primary,
                    window.theme.danger
                ],
                borderWidth: 5
            }]
        },
        options: {
            responsive: !window.MSInputMethodContext,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            cutoutPercentage: 0
        }
    });
});
// GRAFIK PEMAHAMAN & SIKAP
document.addEventListener("DOMContentLoaded", function() {
    // Pie chart
    new Chart(document.getElementById("pahamSikap"), {
        type: "pie",
        data: {
            labels: ["Pemahaman", "Sikap"],
            datasets: [{
                data: [
                    <?= round(($s['11']/$smt),2) ?>, 
                    <?= round(($s['12']/$smt),2) ?>
                ],
                backgroundColor: [
                    window.theme.warning,
                    window.theme.success
                ],
                borderWidth: 5
            }]
        },
        options: {
            responsive: !window.MSInputMethodContext,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            cutoutPercentage: 0
        }
    });
});
// GRAFIK DETAIL QURAN
document.addEventListener("DOMContentLoaded", function() {
    // Bar chart
    new Chart(document.getElementById("quranDetail"), {
        type: "bar",
        data: {
            labels: ["Talaqqi", "Tahfidzh", "Tahsin", "Kitabah"],
            datasets: [{
                label: "This year",
                backgroundColor: window.theme.primary,
                borderColor: window.theme.primary,
                hoverBackgroundColor: window.theme.primary,
                hoverBorderColor: window.theme.primary,
                data: [
                    <?= round(($s['13']/$smt),0) ?>,
                    <?= round(($s['14']/$smt),0) ?>,
                    <?= round(($s['15']/$smt),0) ?>,
                    <?= round(($s['16']/$smt),0) ?>
                ],
                barPercentage: 1,
                categoryPercentage: .75
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false
                    },
                    stacked: false,
                    ticks: {
                        stepSize: 20
                    }
                }],
                xAxes: [{
                    stacked: false,
                    gridLines: {
                        color: "transparent"
                    }
                }]
            }
        }
    });
});
// GRAFIK DETAIL MUROFAQOT
document.addEventListener("DOMContentLoaded", function() {
    // Bar chart
    new Chart(document.getElementById("murofaqot"), {
        type: "bar",
        data: {
            labels: ["Tauhid", "Ibadah", "Baca-Tulis", "Berhitung", "Sains", "Sosial"],
            datasets: [{
                label: "This year",
                backgroundColor: window.theme.success,
                borderColor: window.theme.success,
                hoverBackgroundColor: window.theme.success,
                hoverBorderColor: window.theme.success,
                data: [
                    <?= round(($s['21']/$smt),0) ?>,
                    <?= round(($s['22']/$smt),0) ?>,
                    <?= round(($s['23']/$smt),0) ?>,
                    <?= round(($s['24']/$smt),0) ?>,
                    <?= round(($s['25']/$smt),0) ?>,
                    <?= round(($s['26']/$smt),0) ?>,
                ],
                barPercentage: 1,
                categoryPercentage: .75
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false
                    },
                    stacked: false,
                    ticks: {
                        stepSize: 20
                    }
                }],
                xAxes: [{
                    stacked: false,
                    gridLines: {
                        color: "transparent"
                    }
                }]
            }
        }
    });
});
</script>