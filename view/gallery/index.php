<div class="wrap">
    <div class="col-12">
        <h1 class="row">Gallery
            <a href="<?php echo admin_url('admin.php?page=bsg_createGallery') ?>" class="ml-auto button button-primary">Add Gallery</a>
        </h1>
        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th>SNo.</th>
                    <th>Gallery Name</th>
                    <th>Short-Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($gallery)): ?>
                    <?php foreach($gallery as $index => $item): ?>
                        <tr>
                            <td><?= ($index+1) ?></td>
                            <td><?= $item['gallery_name'] ?></td>
                            <td><?= '[bsgallery id='.$item['id'].']' ?></td>
                            <td>
                                <a href="<?= admin_url('admin.php?page=bsg_editGallery&id='.$item['id']) ?>" title="Edit Gallery">
                                    <i class="dashicons dashicons-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>