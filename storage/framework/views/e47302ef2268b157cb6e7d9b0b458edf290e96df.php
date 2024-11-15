<?php if (isset($component)) { $__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\MasterLayout::class, []); ?>
<?php $component->withName('master-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php echo e(Form::open(['route' => ['provider.destroy', isset($providerdata->id) ? $providerdata->id: $usid], 'method' => 'delete', 'data--submit' => 'provider' . $providerdata->id])); ?>

    <main class="main-area">
        <div class="main-content">
            <div class="container-fluid">
                <?php echo $__env->make('partials._provider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card">
                    <div class="card-body p-30">
                        <div class="provider-details-overview mb-30">
                            <div class="provider-details-overview__collect-cash">
                                <div class="statistics-card statistics-card__collect-cash h-100">
                                    <h3><?php echo e(__('messages.collect_cash')); ?></h3>
                                        <a href="<?php echo e(route('providerpayout.create',$providerdata->id)); ?>" class="btn btn--primary text-capitalize btn--lg mw-75"><?php echo e(__('messages.collect')); ?></a>
                                </div>
                            </div>
                            <div class="provider-details-overview__statistics">
                                <div class="statistics-card statistics-card__style2 statistics-card__pending-withdraw">
                                    <h2><?php echo e(getPriceFormat($providerData['providerTotEarning']) ?? 0); ?></h2>
                                    <h3><?php echo e(__('messages.pending_withdraw')); ?></h3>
                                </div>

                            <div class="statistics-card statistics-card__style2 statistics-card__already-withdraw">
                                <h2><?php echo e(getPriceFormat($providerData['providerTotWithdrableAmt']) ?? 0); ?></h2>
                                <h3><?php echo e(__('messages.already_withdraw')); ?></h3>
                            </div>

                            <div
                                class="statistics-card statistics-card__style2 statistics-card__withdrawable-amount">
                                <h2><?php echo e(getPriceFormat($providerData['providerAlreadyWithdrawAmt']) ?? 0); ?></h2>
                                <h3><?php echo e(__('messages.withdrawble_amount')); ?></h3>
                            </div>

                            <div class="statistics-card statistics-card__style2 statistics-card__total-earning">
                                <h2><?php echo e(getPriceFormat($providerData['pendWithdrwan']) ?? 0); ?></h2>
                                <h3><?php echo e(__('messages.total_earning')); ?></h3>
                            </div>
                        </div>
                        <div class="provider-details-overview__order-overview">
                            <div class="statistics-card statistics-card__order-overview h-100 pb-2">
                                <h3 class="mb-0"><?php echo e(__('messages.booking_overview')); ?></h3>
                                <?php if($data['pendingStatusCount']+$data['cancelledstatuscount']+$data['Completedstatuscount']+$data['Acceptedstatuscount'] > 0): ?>
                                <div id="chart" class="d-flex justify-content-center">

                                </div>
                                <?php else: ?>
                                <p style = "color:#009900; font-size:20px;
                                     font-style:italic; text-align:center; margin-top: 20%;">
                                      <?php echo e(__('messages.nodata')); ?>

                                    
                                  </p>
                                  <?php endif; ?>
                                <div class="resize-triggers">
                                    <div class="expand-trigger">
                                        <div style="width: 310px; height: 234px"></div>
                                    </div>
                                    <div class="contract-trigger"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="information-details-box media flex-column flex-sm-row gap-20">
                                <img class="avatar-img radius-5" src="./img/1.png" alt="" />
                                <div class="media-body">
                                    <h2 class="information-details-box__title">
                                        <?php echo e($providerdata->display_name); ?>

                                    </h2>
                                    <ul class="contact-list">
                                        <li>
                                            <i class="ri-smartphone-line"></i>
                                            <a
                                                href="<?php echo e($providerdata->contact_number); ?>" class="contact-info-text p-0"><?php echo e(!empty($providerdata->contact_number) ? $providerdata->contact_number: '-'); ?></a>
                                        </li>
                                        <li>
                                            <i class="ri-mail-line"></i>
                                            <a href="<?php echo e($providerdata->email); ?>" class="contact-info-text p-0"><?php echo e($providerdata->email); ?></a>
                                        </li>
                                        <li>
                                            <i class="ri-map-2-line"></i>
                                            <span class="contact-info-text"><?php echo e(!empty($providerdata->address) ?$providerdata->address : '-'); ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php echo e(Form::close()); ?>

<?php $__env->startSection('bottom_script'); ?>


    <script type="text/javascript">
        var pendingCount = "<?php echo e($data['pendingStatusCount']); ?>";
        var cancelledCount = parseInt("<?php echo e($data['cancelledstatuscount']); ?>");
        var Completedcount = parseInt("<?php echo e($data['Completedstatuscount']); ?>");
        var Acceptedcount = parseInt("<?php echo e($data['Acceptedstatuscount']); ?>");

        var options = {
            series: [parseInt(pendingCount), cancelledCount, Completedcount, Acceptedcount],
            chart: {
                width: 380,
                type: 'pie',
            },
            labels: ['Pending', 'cancell', 'completed', 'accepted'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
<?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23)): ?>
<?php $component = $__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23; ?>
<?php unset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\newpup\resources\views/provider/view.blade.php ENDPATH**/ ?>