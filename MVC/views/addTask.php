<div class="modal hide" id="addTaskModal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h4>Новая задача <span id="addTaskLink" linkType="0" linkId="<?=$_SESSION['id']?>"><?=$_SESSION['name']?></span></h4>
  </div>
  <div class="modal-body">
  <form style="margin-bottom:0px;" onsubmit="return addTaskSubmit();">
  <table>
  <tr>
  <td><span class="help-block">Задача</span><input tabindex="1" required id="addTaskName" type="text" class="input-large"></td>
  <td><span class="help-block">Ответственный</span><input tabindex="2" data-provide="typeahead" data-items="10" required id="addTaskResponsible" rel="tooltip" data-original-title="Исполнитель задачи. Сотрудник текущей компании." type="text" uId="<?=$_SESSION['id']?>" value="<?=$_SESSION['firstName']?> <?=$_SESSION['secondName']?>" class="input-medium renderTip"></td>
  <td style="padding-bottom: 5px;"><span class="help-block">Крайний срок</span>
  <div class="input-append date" id="datepicker" data-date="<?=date( 'Y-m-d', time()+ (7 * 24 * 60 * 60) )?>" data-date-weekStart="1" data-date-endDate="<?=date( 'Y-m-d', time()+ (12 * 30 * 24 * 60 * 60) )?>" date-today-btn="false" data-date-startDate="<?=date( 'Y-m-d', time() )?>" data-date-autoclose="true" data-date-format="yyyy-mm-dd"><input style="cursor:pointer;" readonly tabindex="4" id="addDeadLine" type="text" value="<?=date( 'Y-m-d', time()+ (7 * 24 * 60 * 60) )?>" class="input-small"><a class="btn add-on" href="#"><i class="icon-calendar"></i></a></div></td></td>
  </tr>
  <tbody id="addTaskOptions" style="display: none;">
  <tr>
  <td><textarea id="addDescription" class="input-large" rows="6" placeholder="Описание"></textarea></td>
  <td style="vertical-align: bottom;" colspan="2">
  <ul id="memberList" class="unstyled">       
  </ul>
  <input id="newMemberInput" type="text" value="" uId="0" class="input-medium" data-provide="typeahead" placeholder="Добавить участников">
  </td>
  </tr>
  </tbody>
  <td colspan="3">
    <div class="btn-toolbar">
		<div class="btn-group">
		<input type="submit" tabindex="3"  href="#" class="btn btn-primary" value="Добавить задачу"></input>
		</div>
		<div class="btn-group">
		<a href="#" class="btn" onclick="taskOptions();">Подробности</a>
		</div>
	</div>
  </td>
  </tr>
  </table>
  </form>
  <div id="addedTasksTableDiv" style="display: none;">
	<table class="table table-bordered">
              <thead>
                <tr>
                  <th>Задача</th>
                  <th>Ответственный</th>
                  <th>Крайний срок</th>
                </tr>
              </thead>
              <tbody id="addedTasksTable">
              </tbody>
            </table>
  </div>
  </div>
</div>
<script>
	<?php
	$stmt=User::getCoWorkersTypeHead();
	$stmtId=User::getCoWorkersTypeHeadId();

	echo 'var subjects = [';
	while($row = $stmt->fetch()) {
		      echo "'$row[firstName] $row[secondName] $row[position]',";
	}
	echo "'$_SESSION[firstName] $_SESSION[secondName]'";
	echo '];';
	
	
	echo 'var subjectsId = [';
	while($row = $stmtId->fetch()) {
		      echo "'$row[userId]',";
	}
	echo "'$_SESSION[id]'";
	echo '];';
	?>
	
	$('#addTaskModal').on('hidden', function () {
        $('#addTaskLink').attr("linkType","0");
		$('#addTaskLink').html("<?=$_SESSION['name']?>");
		$('#addTaskName').attr("value",'');
    })

	if(subjects.length>1){
	    var subjectsM = subjects.slice();
	    subjectsM.pop();
	  
      $('#addTaskResponsible').typeahead({source: subjects,
        updater:function (item) {
		    $("#addTaskResponsible").attr("uId",subjectsId[jQuery.inArray(item, subjects)]);
            return item;
        }
	  });
	  
	  $('#newMemberInput').typeahead({source: subjectsM,
        updater:function (item) {
		    $("#newMemberInput").attr("uId",subjectsId[jQuery.inArray(item, subjectsM)]);
			addMember(item);
        }
	  });
	
	} else {
	    $('#newMemberInput').attr('readonly', true);
		$('#addTaskResponsible').attr('readonly', true);
	}
	
	
	  
  </script>