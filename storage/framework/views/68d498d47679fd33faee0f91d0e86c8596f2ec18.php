<?php if (isset($component)) { $__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\MasterLayout::class, []); ?>
<?php $component->withName('master-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
  <head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  </head>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                            <h5 class="font-weight-bold"><?php echo e($pageTitle ?? trans('messages.list')); ?></h5>
                            <?php if($auth_user->can('subcategory add')): ?>
                            <a href="<?php echo e(route('subcategory.create')); ?>" class="float-right mr-1 btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> <?php echo e(trans('messages.add_form_title',['form' => trans('messages.subcategory')  ])); ?></a>
                            <?php endif; ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
        <div class="row justify-content-between">
            <div>
              <div class="col-md-12">
                  <form action="<?php echo e(route('sub-bulk-action')); ?>" id="quick-action-form" class="form-disabled d-flex gap-3 align-items-center">
                    <?php echo csrf_field(); ?>
                  <select name="action_type" class="form-control select2" id="quick-action-type" style="width:100%" disabled>
                      <option value=""><?php echo e(__('messages.no_action')); ?></option>
                      <option value="change-status"><?php echo e(__('messages.status')); ?></option>
                      <option value="change-featured"><?php echo e(__('messages.featured')); ?></option>
                      <option value="delete"><?php echo e(__('messages.delete')); ?></option>
                      <option value="restore"><?php echo e(__('messages.restore')); ?></option>
                      <option value="permanently-delete"><?php echo e(__('messages.permanent_dlt')); ?></option>
                  </select>
                
                <div class="select-status d-none quick-action-field" id="change-status-action" style="width:100%">
                    <select name="status" class="form-control select2" id="status" >
                      <option value="1"><?php echo e(__('messages.active')); ?></option>
                      <option value="0"><?php echo e(__('messages.inactive')); ?></option>
                    </select>
                </div>
                <div class="select-status d-none quick-action-featured" id="change-featured-action" style="width:100%">
                    <select name="is_featured" class="form-control select2" id="is_featured" >
                      <option value="1"><?php echo e(__('messages.yes')); ?></option>
                      <option value="0"><?php echo e(__('messages.no')); ?></option>
                    </select>
                </div>
                <button id="quick-action-apply" class="btn btn-primary" data-ajax="true"
                data--submit="<?php echo e(route('sub-bulk-action')); ?>"
                data-datatable="reload" data-confirmation='true'
                data-title="<?php echo e(__('subcategory',['form'=>  __('subcategory') ])); ?>"
                title="<?php echo e(__('subcategory',['form'=>  __('subcategory') ])); ?>"
                data-message='<?php echo e(__("Do you want to perform this action??")); ?>' disabled><?php echo e(__('messages.apply')); ?></button>
            </div>
          
            </form>
          </div>
              <div class="d-flex justify-content-end">
                <div class="datatable-filter ml-auto">
                  <select name="column_status" id="column_status" class="select2 form-control" data-filter="select" style="width: 100%">
                    <option value=""><?php echo e(__('messages.all')); ?></option>
                    <option value="0" <?php echo e($filter['status'] == '0' ? "selected" : ''); ?>><?php echo e(__('messages.inactive')); ?></option>
                    <option value="1" <?php echo e($filter['status'] == '1' ? "selected" : ''); ?>><?php echo e(__('messages.active')); ?></option>
                  </select>
                </div>
                <div class="input-group ml-2">
                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control dt-search" placeholder="Search..." aria-label="Search" aria-describedby="addon-wrapping" aria-controls="dataTableBuilder">
                  </div>
              </div>
               
              <div class="table-responsive">
                <table id="datatable" class="table table-striped border">

                </table>
              </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {

        window.renderedDataTable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                dom: '<"row align-items-center"><"table-responsive my-3" rt><"row align-items-center" <"col-md-6" l><"col-md-6" p>><"clear">',
                ajax: {
                  "type"   : "GET",
                  "url"    : '<?php echo e(route("subcategory.sub-index-data")); ?>',
                  "data"   : function( d ) {
                    d.search = {
                      value: $('.dt-search').val()
                    };
                    d.filter = {
                      column_status: $('#column_status').val()
                    }
                  },
                },
                
                columns: [
                    {
                        name: 'check',
                        data: 'check',
                        title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" data-type="subcategory" onclick="selectAllTable(this)">',
                        exportable: false,
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'name',
                        name: 'name',
                        title: "<?php echo e(__('messages.name')); ?>"
                    },
                    {
                        data:'category_id',
                        name:'category_id',
                        title: "<?php echo e(__('messages.category')); ?>"
                    },
                    {
                        data: 'is_featured',
                        name: 'is_featured',
                        title: "<?php echo e(__('messages.featured')); ?>"
                    },
                    {
                        data: 'status',
                        name: 'status',
                        title: "<?php echo e(__('messages.status')); ?>"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        title: "<?php echo e(__('messages.action')); ?>"
                    }
                    
                ]
                
            });
      });

    function resetQuickAction () {
    const actionValue = $('#quick-action-type').val();
    console.log(actionValue)
    if (actionValue != '') {
        $('#quick-action-apply').removeAttr('disabled');

        if (actionValue == 'change-status') {
            $('.quick-action-field').addClass('d-none');
            $('#change-status-action').removeClass('d-none');
        } else {
            $('.quick-action-field').addClass('d-none');
        }
        if (actionValue == 'change-featured') {
            $('.quick-action-featured').addClass('d-none');
            $('#change-featured-action').removeClass('d-none');
        } else {
            $('.quick-action-featured').addClass('d-none');
        }
        } else {
            $('#quick-action-apply').attr('disabled', true);
            $('.quick-action-field').addClass('d-none');
            $('.quick-action-featured').addClass('d-none');
        }
  }
  $('#quick-action-type').change(function () {
    resetQuickAction()
  });

  $(document).on('click', '[data-ajax="true"]', function (e) {
      e.preventDefault();
      const button = $(this);
      const confirmation = button.data('confirmation');

      if (confirmation === 'true') {
          const message = button.data('message');
          if (confirm(message)) {
              const submitUrl = button.data('submit');
              const form = button.closest('form');
              form.attr('action', submitUrl);
              form.submit();
          }
      } else {
          const submitUrl = button.data('submit');
          const form = button.closest('form');
          form.attr('action', submitUrl);
          form.submit();
      }
  });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23)): ?>
<?php $component = $__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23; ?>
<?php unset($__componentOriginalc6e081c8432fe1dd6b4e43af4871c93447ee9b23); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\newpup\resources\views/subcategory/index.blade.php ENDPATH**/ ?>