<?php if ($shortCode == null) : ?>
<form action="" method="post">
    <label>Enter a long URL to make shorten URL</label>
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Please fill with long URL ..." name="url" required>
    </div>
    <br>

    <label>Custom alias (optional)</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><?= _websiteUrlWithoutFile() ?></span>
        </div>
        <input type="text" class="form-control" placeholder="optional" name="alias">
    </div>

    <br>
    <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="1">Shorten</button>
</form>
<?php else: ?>
<div class="card border-success mb-3" >
  <div class="card-header font-weight-bold">Your shorten URL has been successfully created</div>
  <div class="card-body">
    <h5 class="card-title">
        Your long URL : <br>
        <a href="<?= _post('url') ?>">
            <?= _post('url') ?>
        </a>
    </h5>
    <br>
    <h6 class="card-title">
        Your shorten URL : <br>
        <a href="<?= _websiteUrlWithoutFile() . $shortCode ?>">
            <?= _websiteUrlWithoutFile() . $shortCode ?>
        </a>
    </h6>
    <br>
    <?php if ($sameShortCode==true): ?>
        <div class="card-footer bg-transparent border-success text-success">
            Your alias has been taken into account
        </div>
    <?php else: ?>
        <div class="card-footer bg-transparent border-danger text-danger">
            Your alias was already used, we created a random one
        </div>
    <?php endif; ?>
  </div>
</div>

<?php

endif; ?>