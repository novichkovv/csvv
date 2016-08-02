<div class="form-group">
    <label class="control-label col-md-4">QTY</label>
    <div class="col-md-6">
        <input type="text" class="form-control" value="<?php echo $record['qty']; ?>" name="record[qty]">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4">Part Number</label>
    <div class="col-md-6">
        <input type="text" class="form-control" value="<?php echo $record['part_number']; ?>" name="record[part_number]">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4">Manufacturer</label>
    <div class="col-md-6">
        <input type="text" class="form-control" value="<?php echo $record['manufacturer']; ?>" name="record[manufacturer]">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4">Product Line</label>
    <div class="col-md-6">
        <input type="text" class="form-control" value="<?php echo $record['product_line']; ?>" name="record[product_line]">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4">Description</label>
    <div class="col-md-6">
        <input type="text" class="form-control" value="<?php echo $record['description']; ?>" name="record[description]">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-4">Datasheet</label>
    <div class="col-md-6">
        <textarea rows="5" class="form-control" name="record[datasheet]"><?php echo htmlentities($record['datasheet']); ?></textarea>
    </div>
</div>
<input type="hidden" name="record[id]" value="<?php echo $record['id']; ?>">