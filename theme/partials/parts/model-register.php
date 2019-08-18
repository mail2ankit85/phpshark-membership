<!-- The Modal -->
<div class="modal fade" id="model-register">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Register your account</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <?php get_admin_template_part('form', 'register') ?>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
        </div>
    </div>
</div>