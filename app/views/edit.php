<?php if($shorten != null): ?>
<form action="" method="post">
    <label>Long URL</label>
    <div class="input-group">
        <input type="text" class="form-control" value="<?= $shorten->long_url ?>" name="url" required>
    </div>
    <br>

    <label>(Custom) Alias</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><?= _websiteUrlWithoutFile() ?></span>
        </div>
        <input type="text" class="form-control" placeholder="optional" value="<?= $shorten->short_code ?>" name="alias">
    </div>
    <br>

    <!-- EDIT -->
    <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="1">Edit</button>
    <!-- DELETE -->
    <a class="btn btn-danger btn-lg btn-block" href="../controller/delete.php?short_code=<?= $shorten->short_code ?>">Delete</a>
</form>
<?php endif; ?>