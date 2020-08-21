<a href="../controller/create.php" class="btn btn-outline-dark btn-lg btn-block">Create a shorten URL</a>
<p></p>

<?php if (!empty($shorteners)) : ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Long URL</th>
                    <th scope="col">Short URL</th>
                    <th scope="col">Hits</th>
                    <th scope="col">Created</th>
                    <th class="text-center" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shorteners as $key => $shorten) : ?>
                    <tr>
                        <th scope="row"><?= $key + 1 ?></th>
                        <td>
                            <a href="<?= $shorten->long_url ?>">
                                <?= $shorten->long_url ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?= _websiteUrlWithoutFile() . $shorten->short_code ?>">
                                <?= $shorten->short_code ?>
                            </a>
                        </td>
                        <td><?= $shorten->hits ?></td>
                        <td><?= $shorten->created ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-link btn-sm btn-just-icon text-dark" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </button>
                                <div class="dropdown-menu">
                                <a href="../controller/edit.php?short_code=<?= $shorten->short_code ?>" class="dropdown-item">
                                <i class="material-icons">edit</i> Modify
                            </a>
                            <a href="../controller/delete.php?short_code=<?= $shorten->short_code ?>" class="dropdown-item">
                                <i class="material-icons">delete</i> Delete
                            </a>

                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <h3 class="text-danger text-center">No content was found</h3>
<?php endif; ?>

<script>
    function copyToClipboard(id) {
        /* Get the text field */
        var copyText = document.getElementById(id);

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        alert("Copied the text: " + copyText.value);
    }
</script>