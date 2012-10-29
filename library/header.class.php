<?php

class Header
{

    public static function render() {
	    switch (CONTROLLER) {
        case 'login':
           $data['title']='Вход';
        break;
        case 'tasks':
           $data['title']='Задачи';
		   $data['menuPage'] = 'Задачи';
		   $data['menuIcon'] = 'icon-tasks';
        break;
		case 'wall':
           $data['title']='Стена';
		   $data['menuPage'] = 'Стена';
		   $data['menuIcon'] = 'icon-th-list';
        break;
		case 'company':
           $data['title']=$_SESSION['name'];
		   $data['menuPage'] = 'Компания';
		   $data['menuIcon'] = 'icon-briefcase';
        break;
        }

		renderView('header', $data);
		if(CONTROLLER != 'login'){
		    User::updateOnlineStatus();
		    $data['MembershipList'] = User::getMembershipList();
			$data['newMessages'] = 2;                                           //todo messages		
			$updatedTasks = TaskList::getUpdatedTasks();
			if($updatedTasks>0){
			    $data['activeTasks'] = $updatedTasks;
			    $tasksStatus = 'updated';
			} else {
			    $uncompleteTasks = TaskList::getUncompleteTasks();
				if($uncompleteTasks>0){
				    $data['activeTasks'] = $uncompleteTasks;
			        $tasksStatus = 'active';
				} else {
				    $data['activeTasks']=0;
					$tasksStatus = 'empty';
				}
			}
			switch ($tasksStatus) {
                case 'updated':
                    $data['tasksButton'] = "btn-danger";
                break;
                case 'active':
                    $data['tasksButton'] = "btn-info";
                break;
		        case 'empty':
                    $data['tasksButton'] = "";
                break;
            }
			renderView('addTask', $data);
		    renderView('userPanel', $data);
		}
	}

	
}