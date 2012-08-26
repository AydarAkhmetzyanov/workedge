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
		   $data['menuActions'] = '<li><a data-toggle="modal" href="#addTaskModal"><i class="icon-plus"></i> Добавить задачу</a></li>';
        break;
		case 'wall':
           $data['title']='Стена';
		   $data['menuPage'] = 'Стена';
		   $data['menuIcon'] = 'icon-th-list';
		   $data['menuActions'] = '';
        break;
		case 'company':
           $data['title']='Компания';
		   $data['menuPage'] = 'Компания';
		   $data['menuIcon'] = 'icon-briefcase';
		   $data['menuActions'] = '';
        break;
        }

		renderView('header', $data);
		if(CONTROLLER != 'login'){
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