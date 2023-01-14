</div>
</main>
<footer id="page-footer">
    <div class="content py-3">
        <div class="row fs-sm">
            <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
                Crafted with <i class="fa fa-heart text-danger"></i> by <a class="fw-semibold" href="https://osuu.cc/" target="_blank">CloudZA</a>
            </div>
            <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                <a class="fw-semibold" href="https://1.envato.market/95j" target="_blank"><?php
                    echo FOOTER_BAN ?> </a> &copy; <span
                        data-toggle="year-copy"></span>
            </div>
        </div>
    </div>
</footer>
</div>
<script src="../assets/js/codebase.app.min-5.4.js"></script>
<!--<script src="../assets/js/lib/jquery.min.js"></script>-->
<script src="../assets/js/plugins/jquery-pjax/jquery.pjax.js"></script>
<script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-0-M/nprogress/0.2.0/nprogress.min.js"></script>
<script src="../assets/js/dashboard.js"></script>
<script src="../assets/js/bootstrap-notify.min.js"></script>
<script src="../assets/js/layer.js"></script>
<script src="https://lf6-cdn-tos.bytecdntp.com/cdn/expire-0-M/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
<script src="../assets/js/chart.min.js"></script>
<script src="../assets/js/app.min.js"></script>

<script>

    $(function () {
        $(function () {
            Codebase.helpers('jq-slimscroll');
        });
    })
    // 图表类

    Codebase.onLoad(() =>
        class
        {
            static initChartsChartJS ()
            {
                (Chart.defaults.color = "#818d96"),
                    (Chart.defaults.scale.grid.color = "rgba(0,0,0,.04)"),
                    (Chart.defaults.scale.grid.zeroLineColor = "rgba(0,0,0,.1)"),
                    (Chart.defaults.scale.beginAtZero = !0),
                    (Chart.defaults.elements.line.borderWidth = 2),
                    (Chart.defaults.elements.point.radius = 5),
                    (Chart.defaults.elements.point.hoverRadius = 7),
                    (Chart.defaults.plugins.tooltip.radius = 3),
                    (Chart.defaults.plugins.legend.labels.boxWidth = 12);
                let
                    n = document.getElementById("js-chartjs-lines"),
                    d = document.getElementById("js-chartjs-bars"),
                    c = {
                        labels: ["周一", "周二", "周三", "周四", "周五", "周六", "周日"],
                        datasets: [
                            {
                                label: "本周",
                                fill: !0,
                                backgroundColor: "rgba(2, 132, 199, .75)",
                                borderColor: "rgba(2, 132, 199, 1)",
                                pointBackgroundColor: "rgba(2, 132, 199, 1)",
                                pointBorderColor: "#fff",
                                pointHoverBackgroundColor: "#fff",
                                pointHoverBorderColor: "rgba(2, 132, 199, 1)",
                                data: [25, 38, 62, 45, 90, 123, 130]
                            },
                            {
                                label: "上周",
                                fill: !0,
                                backgroundColor: "rgba(2, 132, 199, .25)",
                                borderColor: "rgba(2, 132, 199, 1)",
                                pointBackgroundColor: "rgba(2, 132, 199, 1)",
                                pointBorderColor: "#fff",
                                pointHoverBackgroundColor: "#fff",
                                pointHoverBorderColor: "rgba(2, 132, 199, 1)",
                                data: [112, 90, 142, 130, 170, 163, 196]
                            }
                        ]
                    },
                    f = {
                        labels: ["周一", "周二", "周三", "周四", "周五", "周六", "周日"],
                        datasets: [
                            {
                                label: "本周",
                                fill: !0,
                                backgroundColor: "rgba(2, 132, 199, .75)",
                                borderColor: "rgba(2, 132, 199, 1)",
                                pointBackgroundColor: "rgba(2, 132, 199, 1)",
                                pointBorderColor: "#fff",
                                pointHoverBackgroundColor: "#fff",
                                pointHoverBorderColor: "rgba(2, 132, 199, 1)",
                                data: [32, 45, 72, 55, 120, 155, 130]
                            },
                            {
                                label: "上周",
                                fill: !0,
                                backgroundColor: "rgba(2, 132, 199, .25)",
                                borderColor: "rgba(2, 132, 199, 1)",
                                pointBackgroundColor: "rgba(2, 132, 199, 1)",
                                pointBorderColor: "#fff",
                                pointHoverBackgroundColor: "#fff",
                                pointHoverBorderColor: "rgba(2, 132, 199, 1)",
                                data: [112, 90, 142, 130, 170, 188, 196]
                            }
                        ]
                    };
                // 曲线图
                null !== n &&
                (new Chart(n, {
                    type: "line",
                    data: c,
                    options: {tension: 0.4}
                }))
                // 柱形图
                null !== d &&
                (new Chart(d, {
                    type: "bar",
                    data: f
                }))
            }

            static initRandomEasyPieChart ()
            {
                document.querySelectorAll(".js-pie-randomize").forEach((a) => {
                    a.addEventListener("click", (t) => {
                        a.closest(".block")
                            .querySelectorAll(".pie-chart")
                            .forEach((a) => {
                                jQuery(a)
                                    .data("easyPieChart")
                                    .update(Math.floor(100 * Math.random() + 1));
                            });
                    });
                });
            }

            static init ()
            {
                this.initRandomEasyPieChart(), this.initChartsChartJS();
            }
        }.init()
    );

</script>
</body>
</html>