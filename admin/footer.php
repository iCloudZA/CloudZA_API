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
<script src="https://cdn.staticfile.org/nprogress/0.2.0/nprogress.js"></script>
<script src="../assets/js/codebase.app.min-5.4.js"></script>
<script src="../assets/js/plugins/jquery-pjax/jquery.pjax.js"></script>
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
    // ChartJS
    x.ajax('index.php?api=chart',{},(data)=>{
        if(data.code === '200'){
            let item = data.data
            x.barCharts(item.date,item.pv,item.ip);
        }
    })
</script>
</body>
</html>