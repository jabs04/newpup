<?php if (isset($component)) { $__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\MasterLayout::class, []); ?>
<?php $component->withName('master-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-body">
                  <div id='calendar'></div>
                </div>
              </div>
            </div>
        </div>
        <!-- Page end  -->
    </div>
    <?php $__env->startSection('bottom_script'); ?>
    <script>
    if (jQuery('#calendar').length) {
      document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {

      plugins: [ 'dayGrid','timeGrid', 'dayGrid', 'list','interaction','bootstrap' ],
      defaultView: 'dayGridMonth',
      displayEventTime: true,
      themeSystem: 'bootstrap',
      header: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
          clear: ''
      },
      height : 600,
      selectable: true,
      selectHelper: true,
      editable: true,
      eventLimit: false,
      showNonCurrentDates : false,
      droppable: false,
      editable:false,
      eventSources:[{
        events: function (info, successCallback, failureCallback) {
            $.ajax({
                url:  "<?php echo e(route('home')); ?>",
                dataType: 'JSON',
                data: {
                    start: info['startStr'],
                    end: info['endStr'],
                    _token: "<?php echo e(csrf_token()); ?>"
                },
                success: function(response) {
                    successCallback(response);
                    return response;
                },
                failure: function(data){
                    failureCallback(data);
                }
            });
        },
        color  : "rgb(19, 193, 240)",
        textColor : "#fff",
        eventDataTransform: function(eventData) {
          return {
              id: eventData.id,
              title: (eventData.service != null && eventData.service != '') ? eventData.service.name : '-' ,
              start: eventData.date,
          };
        },
      }],
      eventRender: function (event, element, view) {
          if (event.allDay === 'true') {
              event.allDay = true;
          } else {
              event.allDay = false;
          }
      },
      eventDrop: function(info) {},
      eventClick:  function(info) {
        var id = info.event.id;
        var url = "<?php echo e(URL::to('booking')); ?>/"+id;
        window.location.replace(url);
      },
    });
    calendar.render();
    });
    }
</script>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23)): ?>
<?php $component = $__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23; ?>
<?php unset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23); ?>
<?php endif; ?>

<?php /**PATH C:\xampp\htdocs\newpup\resources\views/dashboard/user-dashboard.blade.php ENDPATH**/ ?>