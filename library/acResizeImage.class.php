<?
/**
* acResizeImage
* 
* Класс для изменения размеров изображений. Реализованы различные методы ресайза, кроп, а также создание миниатюр.
* 
* @author Загорцев Андрей Михайлович <freeron@yandex.ru>
* @version 1.0
*/

class AcResizeImage
{
	private $image;
	private $width; 
	private $height;
	private $type;
	
	/**
	* Инициализация объекта
	* @param $file string	Путь к временному файлу
	*/
	function __construct($file)
	{
		if (@!file_exists($file)) exit("File does not exist");
		if(!$this->setType($file)) exit("File is not an image");
		$this->openImage($file);
		$this->setSize();
	}
	
	/**
	* Изменение размеров изображения
	*
	* Оба принимаемых параметра необязательны.
	* Если переданы и ширина и высота, изображение ужмётся в рамки.
	* Если передана лишь ширина - изображение сжимается по ней (аналогично и с высотой)
	*
	* @param $width integer		Новая ширина изображения
	* @param $height integer	Новая высота изображения
	* @return object 			Текущий объект класса 
	*/
	function resize($width = false, $height = false)
	{
		/**
		* В зависимости от типа ресайза, запишем в $newSize новые размеры изображения.
		*/
		if(is_numeric($width) && is_numeric($height) && $width > 0 && $height > 0)
		{
			$newSize = $this->getSizeByFramework($width, $height);
		}
		else if(is_numeric($width) && $width > 0)
		{
			$newSize = $this->getSizeByWidth($width);
		}
		else if(is_numeric($height) && $height > 0)
		{
			$newSize = $this->getSizeByHeight($height);
		}
		else $newSize = array($this->width, $this->height);
		$newImage = imagecreatetruecolor($newSize[0], $newSize[1]);
		//завернуть в отдельную функцию, сжимающую изображение поэтапно
		imagecopyresampled($newImage, $this->image, 0, 0, 0, 0, $newSize[0], $newSize[1], $this->width, $this->height);
		$this->image = $newImage;
		$this->setSize();
		return $this;
	}
	
	/**
	* Функция для обрезки изображения.
	* Функция cropSave сохраняет обрезанное изображение и возвращает текущий объект класса acResizeImage.
	* 
	* @param $x0 integer	Координата x точки начала обрезки
	* @param $y0 integer	Координата y точки начала обрезки
	* @param $w integer		Ширина вырезаемой области
	* @param $h integer		Высота вырезаемой области
	* @return object		Текущий объект класса 
	*/
	function crop($x0 = 0, $y0 = 0, $w = false, $h = false)
	{
		if(!is_numeric($x0) || $x0 < 0 || $x0 >= $this->width) $x0 = 0;
		if(!is_numeric($y0) || $y0 < 0 || $y0 >= $this->height) $y0 = 0;
		if(!is_numeric($w) || $w <= 0 || $w > $this->width - $x0) $w = $this->width - $x0;
		if(!is_numeric($h) || $h <= 0 || $h > $this->height - $y0) $h = $this->height - $y0;
		return $this->cropSave($x0, $y0, $w, $h);
	}
	
	/**
	* Функция, вырезающая квадратную область из исходного изображения
	* Функция cropSave сохраняет обрезанное изображение и возвращает текущий объект класса acResizeImage.
	* Все параметры необязательны.
	* Если не было ничего передано, будет вырезана центральная максимальная квадратная область.
	* 
	* @param $x0 integer		Координата x точки начала обрезки (по умолчанию - false)
	* @param $y0 integer		Координата y точки начала обрезки (по умолчанию - false)
	* @param $size integer		Сторона вырезаемой квадратной области
	* @return object 			Текущий объект класса 
	*/
	function cropSquare($x0 = false, $y0 = false, $size = false)
	{
		if(!is_numeric($size) || $size <= 0) $size = false;
		if(!is_numeric($x0) && !is_numeric($y0))
		{
			if($this->width < $this->height)
			{
				$x0 = 0;
				if(!$size || $size > $this->width)
				{
					$size = $this->width;
					$y0 = round(($this->height - $size) / 2);
				}
				else $y0 = 0;
			}
			else
			{
				$y0 = 0;
				if(!$size || $size > $this->height)
				{
					$size = $this->height;
					$x0 = round(($this->width - $size) / 2);
				}
				else $x0 = 0;
			}
		}
		else
		{
			if(!is_numeric($x0) || $x0 <= 0 || $x0 >= $this->width) $x0 = 0;
			if(!is_numeric($y0) || $y0 <= 0 || $y0 >= $this->height) $y0 = 0;
			if(!$size || $this->width < $size + $x0) $size = $this->width - $x0;
			if(!$size || $this->height < $size + $y0) $size = $this->height - $y0;
		}
		return $this->cropSave($x0, $y0, $size, $size);
	}
	
	/**
	* Приватная функция, сохраняющая обрезанное изображение.
	* 
	* @return object	Текущий объект класса 
	*/
	private function cropSave($x0, $y0, $w, $h)
	{
		$newImage = imagecreatetruecolor($w, $h);
		imagecopyresampled($newImage, $this->image, 0, 0, $x0, $y0, $w, $h, $w, $h);
		$this->image = $newImage;
		$this->setSize();
		return $this;
	}
	
	/**
	* Функция для создания миниатюр изображений.
	* Функция getSizeByThumbnail возвращает новые размеры изображения.
	* 
	* @param $width integer		Ширина миниатюры
	* @param $height integer	Высота миниатюры
	* @param $c integer			Коэффициент превышения...
	* @return object			Текущий объект класса 
	*/
	function thumbnail($width, $height, $c = 2)
	{
		if(!is_numeric($width) || $width <= 0) $width = $this->width;
		if(!is_numeric($height) || $height <= 0) $height = $this->height;
		if(!is_numeric($c) || $c <= 1) $c = 2;
		$newSize = $this->getSizeByThumbnail($width, $height, $c);
		$newImage = imagecreatetruecolor($newSize[0], $newSize[1]);
		imagecopyresampled($newImage, $this->image, 0, 0, 0, 0, $newSize[0], $newSize[1], $this->width, $this->height);
		$this->image = $newImage;
		$this->setSize();
		return $this;
	}
	
	/**
	* Функция, сохраняющая изображение в файл
	* 
	* @param $path string		Путь, по которому следует сохранить файл
	* @param $fileName string	Имя нового файла
	* @param $type string		Тип файла (по умолчанию (false) - тот же, что и у исходного изображения)
	* @param $rewrite boolean	Флаг, определяющий, можно ли перезаписывать файлы с одинаковыми именами
	* @param $quality integer	Качество изображения для JPG-файлов
	* @return string			Адрес нового файла
	*/
	function save($path = '', $fileName, $type = false, $rewrite = false, $quality = 100)
	{
		if(trim($fileName) == '' || $this->image === false) return false;
		$type = strtolower($type);
		switch($type)
		{
			case false:
				$savePath = $path.trim($fileName).".".$this->type;
				switch($this->type)
				{
					case 'jpg':
						if(!$rewrite && @file_exists($savePath)) return false;
						if(!is_numeric($quality) || $quality < 0 || $quality > 100) $quality = 100;
						imagejpeg($this->image, $savePath, $quality);
						return $savePath;
					case 'png':
						if(!$rewrite && @file_exists($savePath)) return false;
						imagepng($this->image, $savePath);
						return $savePath;
					case 'gif':
						if(!$rewrite && @file_exists($savePath)) return false;
						imagegif($this->image, $savePath);
						return $savePath;
					default:
						return false;
				}
				break;
			case 'jpg':
				$savePath = $path.trim($fileName).".".$type;
				if(!$rewrite && @file_exists($savePath)) return false;
				if(!is_numeric($quality) || $quality < 0 || $quality > 100) $quality = 100;
				imagejpeg($this->image, $savePath, $quality);
				return $savePath;
			case 'png':
				$savePath = $path.trim($fileName).".".$type;
				if(!$rewrite && @file_exists($savePath)) return false;
				imagepng($this->image, $savePath);
				return $savePath;
			case 'gif':
				$savePath = $path.trim($fileName).".".$type;
				if(!$rewrite && @file_exists($savePath)) return false;
				imagegif($this->image, $savePath);
				return $savePath;
			default:
				return false;
		}
	}
	
	/**
	* Приватная функция, "открывающая" файл в зависимости от типа изображения.
	* 
	* @param $file string	Путь исходного файла
	*/
	private function openImage($file)
	{
		switch($this->type)
		{
			case 'jpg':
				$this->image = @imagecreatefromjpeg($file);
				break;
			case 'png':
				$this->image = @imagecreatefrompng($file);
				break;
			case 'gif':
				$this->image = @imagecreatefromgif($file);
				break;
			default:
				exit("File is not an image");
		}
	}
	
	/**
	* Приватная функция, записывающая в поле type тип исходного изображения
	* 
	* @param $file string	Путь исходного файла	
	* @return boolean		TRUE, если файл является изображением. FALSE - в противном случае.
	*/
	private function setType($file)
	{
	    $params = getimagesize ($file);
switch ($params [2]) { 
 case 1 : 
 $this->type = "gif";
				return true;
 break; 
 case 2 : 
 $this->type = "jpg";
				return true; 
 break; 
 case 3 : 
 $this->type = "png";
				return true;
 default : 
 return false;
 break; 
}
	}
	
	/**
	* Приватная функция, записывающая размеры исходного изображения
	*/
	private function setSize()
	{
		$this->width = imagesx($this->image);
		$this->height = imagesy($this->image);
	}
	
	/**
	* Приватная функция, определяющая размеры нового изображения при вписывании его в рамки.
	* Сжатие происходит пропорционально.
	* 
	* @param $width integer		Максимальная ширина нового изображения
	* @param $height integer	Максимальная высота нового изображения
	* @return array 			Массив, содержащий размеры нового изображения
	*/
	private function getSizeByFramework($width, $height)
	{
		if($this->width <= $width && $this->height <= height) 
			return array($this->width, $this->height);
		if($this->width / $width > $this->height / $height)
		{
			$newSize[0] = $width;
			$newSize[1] = round($this->height * $width / $this->width);
		}
		else
		{
			$newSize[1] = $height;
			$newSize[0] = round($this->width * $height / $this->height);
		}
		return $newSize;
	}
	
	/**
	* Приватная функция, определяющая размеры нового изображения при сжатии по ширине.
	* Сжатие происходит пропорционально.
	* 
	* @param $width integer		Максимальная ширина нового изображения
	* @return array 			Массив, содержащий размеры нового изображения
	*/
	private function getSizeByWidth($width)
	{
		if($width >= $this->width) return array($this->width, $this->height);
		$newSize[0] = $width;
		$newSize[1] = round($this->height * $width / $this->width);
		return $newSize;
	}
	
	/**
	* Приватная функция, определяющая размеры нового изображения при сжатии по высоте.
	* Сжатие происходит пропорционально.
	* 
	* @param $height integer	Максимальная высота нового изображения
	* @return array 			Массив, содержащий размеры нового изображения
	*/
	private function getSizeByHeight($height)
	{
		if($height >= $this->height) return array($this->width, $this->height);
		$newSize[1] = $height;
		$newSize[0] = round($this->width * $height / $this->height);
		return $newSize;
	}
	
	/**
	* Приватная функция, определяющая размеры нового изображения при создании миниатюры.
	* Функция вписывает изображение в указанную область, стараясь максимально заполнить её.
	* Если после ужатия по одной из сторон, вторая сторона привышает размеры области более чем в $c раз,
	* то ужатие происходит по второй стороне.
	* Если же вторая сторона превышает размер области в 2 * $c раз, то стороны уменьшаются в 2 раза.
	* Если одна из сторон заведомо меньше соответствующей стороны области,
	* проверяется, не превышает ли другая сторона соответствующую сторону области в $c раз и 2 * $c.
	* Если ресайз производится не по ширине, а по высоте, переменные, содержащие размеры исходного изображения
	* и размеры миниатюры, меняются местами.
	* Также местами меняются мирина и высота в возвращаемом массиве.
	* 
	* @param $width integer		Максимальная ширина нового изображения
	* @param $height integer	Максимальная высота нового изображения
	* @param $с integer			Коэффициент превышения...
	* @return array 			Массив, содержащий размеры нового изображения
	*/
	private function getSizeByThumbnail($width, $height, $c)
	{
		if($this->width <= $width && $this->height <= height) 
			return array($this->width, $this->height);
		$realW = $this->width;
		$realH = $this->height;
		
		$rotate = false;
		if($width / $realW <= $height / $realH)
		{
			$t = $realH;
			$realH = $realW;
			$realW = $t;
			$t = $width;
			$width = $height;
			$height = $t;
			$rotate = true;
		}
		
		$limX = $c * $width;
		$limY = $c * $height;
		$possH = $realH * $width / $realW;
		
		if($realW > $width)
		{
			if($possH <= $limY)
			{
				$newSize[0] = $width;
				$newSize[1] = round($possH);
			}
			else
			{
				if($possH <= 2 * $limY)
				{
					$newSize[1] = $limY;
					$newSize[0] = $realW * $newSize[1] / $realH;
				}
				else
				{
					$newSize[0] = $width / 2;
					$newSize[1] = $realH * $newSize[0] / $realW;
				}
			}
		}
		else
		{
			if($realH <= $limY)
			{
				$newSize[0] = $realW;
				$newSize[1] = $realH;
			}
			else
			{
				if($realH <= 2 * $limY)
				{
					if($realW * $limY / $realH >= $width / 2)
					{
						$newSize[1] = $limY;
						$newSize[0] = $realW * $limY / $realH;
					}
					else
					{
						$newSize[0] = $width / 2;
						$newSize[1] = $realH * $newSize[0] / $realW;
					}
				}
				else
				{
					$newSize[0] = $width / 2;
					$newSize[1] = $realH * $newSize[0] / $realW;
				}
			}
		}
		if($rotate)
		{
			$t = $newSize[0];
			$newSize[0] = $newSize[1];
			$newSize[1] = $t;
		}
		return $newSize;
	}
}