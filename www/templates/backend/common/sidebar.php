<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu page-sidebar-menu-closed" data-auto-scroll="true" data-slide-speed="200">
            <li class="start <?php if(registry::get('route_parts')[0] == 'index') echo 'active'; ?>">
                <a href="<?php echo SITE_DIR; ?>backend/">
                    <i class="icon-list"></i>
                    <span class="title">Data Table</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="start <?php if(registry::get('route_parts')[0] == 'download') echo 'active'; ?>">
                <a href="<?php echo SITE_DIR; ?>backend/download/">
                    <i class="fa fa-download"></i>
                    <span class="title">Download</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="start <?php if(registry::get('route_parts')[0] == 'upload') echo 'active'; ?>">
                <a href="<?php echo SITE_DIR; ?>backend/upload/">
                    <i class="fa fa-upload"></i>
                    <span class="title">Upload</span>
                    <span class="selected"></span>
                </a>
            </li>
        </ul>
    </div>
</div>