<!DOCTYPE html>
<html lang="en">
    <head>
      <title>Bootstrap Example</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
          <h2>Basic Modal Example</h2>
          <!-- Trigger the modal with a button -->
                <select> 
                    <option> List 1 </otion>
                    <option> list 2</option>
                    <option> List 3</option>
                    <option  data-toggle="modal" data-target="#myModal"> Click For Modal </option>
                </select>
          <!-- Modal -->
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">      
                  <!-- Modal content-->
                  <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Modal Header</h4>
                        </div>
                        <div class="modal-body">
                          <p>Some text in the modal.</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                  </div>          
                </div>
              </div>  
        </div>
    </body>
</html>