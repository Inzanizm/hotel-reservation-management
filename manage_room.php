<?php
include('initialize.php');



?>
<style>
	img#cimg{
		height: 17vh;
		width: 25vw;
		object-fit: scale-down;
	}
</style>
<div class="container-fluid">
    <form action="" id="room-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="control-label">Room Number</label>
                    <input type="text" name="number" id="name" class="form-control form-control-border" placeholder="Enter room Name" value ="<?php echo isset($number) ? $number : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="type" class="control-label">Type</label>
                    <select name="type" id="type" class="form-control form-control-border" placeholder="Enter room Name" value ="<?php echo isset($type) ? $type : '' ?>" required>                        
                        <?php
                            $room_types = $connection->query("SELECT * FROM room_type_tb ORDER BY room_name ASC");
                            while($row = $room_types->fetch_assoc()):
                        ?>
                            <option value="<?= $row['room_type_id'] ?>" <?= isset($type) && $type == $row['room_type_id'] ? 'selected' : "" ?>><?= $row['room_name'] ?></option>
                        <?php endwhile; ?>
                    </select>    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="price" class="control-label">Price</label>
                    <input type="number" step="any" name="price" id="price" class="form-control form-control-border text-right" value ="<?php echo isset($price) ? $price : 0 ?>" required>
                </div>
                <div class="form-group">
                    <label for="status" class="control-label">Status</label>
                    <select name="status" id="status" class="form-control form-control-border" placeholder="Enter room Name" required>
                        <option value="4" <?= isset($status) && $status == 4 ? 'selected' : "" ?>>Occupied</option>
                        <option value="3" <?= isset($status) && $status == 3 ? 'selected' : "" ?>>Maintenance</option>
                        <option value="2" <?= isset($status) && $status == 2 ? 'selected' : "" ?>>Reserved</option>
                        <option value="1" <?= isset($status) && $status == 1 ? 'selected' : "" ?>>Available</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="description" class="control-label">Description</label>
            <textarea row="3" name="description" id="description" class="form-control form-control-border text-right summernote" required><?php echo isset($description) ? html_entity_decode($description) : '' ?></textarea>
        </div>

        <!-- <div class="form-group col-md-6">
				<label for="" class="control-label">Image</label>
				<div class="custom-file">
	              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
	              <label class="custom-file-label" for="customFile">Choose file</label>
	            </div>
			</div>
			<div class="form-group col-md-6 d-flex justify-content-center">
				<img src="front-end/page1/WEBSITE IMG/pexels-pixabay-258154.jpg" alt="" id="cimg" class="img-fluid img-thumbnail">
			</div> -->
    </form>
</div>
<?php
if(isset($_GET['id'])){
    $qry = $connection->query("SELECT * FROM `rooms_tb` where room_id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
if(isset($_GET['f']) && $_GET['f'] == 'save_room') {
    $id = $_POST['id'];
    $number = $_POST['number'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $description = $_POST['descriptions'];
   

    

    if($id != '') {
        // UPDATE
        $query = "UPDATE rooms_tb SET 
                    room_number='$number', 
                    room_type_id='$type', 
                    room_status_id='$status',
                    descriptions='$description'
                  ";
    
        $query .= " WHERE room_id='$id'";
    } else {
        // INSERT
        $query = "INSERT INTO rooms_tb (room_number, room_type_id,room_status_id, descriptions)
                  VALUES ('$number', '$type', '$status', '$description')";
    }
    
    if ($connection->query($query)) {
        echo json_encode([
            'status' => 'success',
            'id' => $id != '' ? $id : $connection->insert_id
        ]);
    } else {
        echo json_encode([
            'status' => 'failed',
            'msg' => 'Database error: ' . $connection->error
        ]);
    }
    exit;
}
?>
<script>
    function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	_this.siblings('.custom-file-label').html(input.files[0].name)
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
            $('#cimg').attr('src', "front-end/page1/WEBSITE IMG/pexels-pixabay-258154.jpg");
            _this.siblings('.custom-file-label').html("Choose file")
        }
	}
    $(function(){
        $('#uni_modal').on('shown.bs.modal',function(){
            $('#description').summernote({
                placeholder:'Write the Room Description here.',
                height: '50vh',
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
					['insert', ['link', 'picture']],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
            })
        })
        $('#uni_modal #room-form').submit(function(e){
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url: "Master.php?f=save_room",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
                success:function(resp){
                    if(resp.status == 'success'){
                        location.href = './?page=rooms/view_room&id='+resp.id;
                    }else if(!!resp.msg){
                        el.addClass("alert-danger")
                        el.text(resp.msg)
                        _this.prepend(el)
                    }else{
                        el.addClass("alert-danger")
                        el.text("An error occurred due to unknown reason.")
                        _this.prepend(el)
                    }
                    el.show('slow')
                    $('html,body,.modal').animate({scrollTop:0},'fast')
                    end_loader();
                }
            })
        })
    })
</script>