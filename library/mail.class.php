<?php

class Mail
{
    
    public static function send($html, $email) { //��� ������������ ��������� � ������������ ������
		echo 'send';
		$result = true;
		return $result;
	}
	
	
	
    public static function sendPasswordRecovery($email, $recoveryLink, $firstName, $lastName) {  //�������������� ������ ��� ������������
	    $html = '��������� ������';
		return Mail::send($html,$email);
	}
	
	public static function sendInvite($email, $inviteLink, $firstName, $lastName, $company) {  //����������� ������ ������������ � �����������
	    $html = '��������� ������';
		return Mail::send($html,$email);
	}
	
	public static function sendEmailValidation($email, $inviteLink, $firstName, $lastName) {  //������������� email
	    $html = '��������� ������';
		return Mail::send($html,$email);
	}
	
}