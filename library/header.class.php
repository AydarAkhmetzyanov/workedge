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
		case 'coworkers':
           $data['title']='Сотрудники';
        break;
        }

		renderView('header', $data);
		if(CONTROLLER != 'login'){
		    $data['MembershipList'] = User::getMembershipList();
			$data['newMessages'] = 2;
			
			$data['activeTasks'] = 3;
			$tasksStatus = 'active';
			switch ($tasksStatus) {
                case 'updated':
                    $data['tasksButton'] = "btn-success";
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