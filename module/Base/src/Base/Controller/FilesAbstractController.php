<?php

namespace Base\Controller;

/**
 * Description of FilesAbstractController
 *
 * @author mauricioschmitz
 */

use Zend\View\Model\JsonModel;

abstract class FilesAbstractController extends AbstractController{
    
    protected $extensions = array();
    protected $tamanhos = array(1024);
    protected $dir = '';
    protected $marcadagua = array();

    /**
     * Abstract method
     */
    abstract public function tratarArquivo($id, $arquivo);
    
    /**
     * @return array of files
     */
    public function imageUploadAction(){
        $folder = getcwd() . '/public/uploads/' . $this->dir;
        $retorno = 'false';
        if($_FILES['files']['name']!= ""){
            $ext = explode('.',$_FILES['files']['name']);
            $qt = count($ext);
            $ext = $ext[$qt-1];
            if (!in_array(strtolower($ext),$this->extensions)) {
                $retorno = "invalido";
                
            }else{
                $name = $_FILES['files']['name'];
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $nomeOriginal = pathinfo($name, PATHINFO_FILENAME);
                $novoNome = (md5($name . '_' . time()) . '.' . $extension);
                $novoNomeWithoutExtension = (md5($name . '_' . time()));
                
                $medida = getimagesize($_FILES['files']['tmp_name']);
                $thumbsX = array();
                $thumbsY = array();
                
                if($medida[0]>$medida[1]) {
                    if($this->tamanhos[0] > $medida[0]){
                        $x = $medida[0];
                        if($this->tamanhos[0] > $medida[1]){
                            $y = $medida[1];
                        }
                    }else{
                        $x = $this->tamanhos[0];
                        $y = $medida[1]/($medida[0]/$this->tamanhos[0]);
                    }
                    
                    $tamanhos = $this->tamanhos;
                    for($i = 1; $i < count($tamanhos); $i++){
                        array_push($thumbsX, $tamanhos[$i]);
                        array_push($thumbsY, $medida[1]/($medida[0]/$tamanhos[$i]));
                    }
                }else{
                    if($this->tamanhos[0]  > $medida[1]){
                        $y = $medida[1];
                        if($this->tamanhos[0]  > $medida[0]){
                            $x = $medida[0];
                        }
                    }else{
                        $y = $this->tamanhos[0] ;
                        $x = $medida[0]/($medida[1]/$this->tamanhos[0] );
                    }

                    $tamanhos = $this->tamanhos;
                    for($i = 1; $i < count($tamanhos); $i++){
                        array_push($thumbsY, $tamanhos[$i]);
                        array_push($thumbsX, $medida[0]/($medida[1]/$tamanhos[$i]));
                    }
                }
                
                $watermark = $this->getServiceLocator()->get('WaterMark');
                $watermark_options = array(
                          'halign' => 0,
                          'valign' => 0,
                          'hshift' => -10,
                          'vshift' => -10,
                          'type' => IMAGETYPE_JPEG,
                          'jpeg-quality' => 80,
                        );
                if($extension == 'jpg' || $extension == 'jpeg'){
                    //cria imagem temporarioa
                    $imagem = imagecreatefromjpeg($_FILES['files']['tmp_name']);

                    //imagem
                    $final = imagecreatetruecolor($x, $y);
                    imagecopyresampled($final, $imagem,0, 0, 0, 0, $x, $y, $medida[0], $medida[1]);
                    
                    if($this->marcadagua[0] != ''){
                        $watermark_options['watermark'] = $folder . $this->marcadagua[0];
                        // Save watermarked image to file
                        $final = $watermark->output($final, $folder .$novoNome, $watermark_options);
                    }else{
                        imagejpeg($final, $folder .$novoNome, 80);
                        imagedestroy($final);
                    }
                    
                    $arquivo = array('nomeOriginal'=>$nomeOriginal, 'novoNome' => $novoNome);
                    for($i = 0; $i < count($thumbsX); $i++){
                        $nomeThumb = $novoNomeWithoutExtension.'_'.$this->tamanhos[($i+1)].'.'.$extension;
                        $thumb = imagecreatetruecolor($thumbsX[$i], $thumbsY[$i]);
                        imagecopyresampled($thumb, $imagem,0, 0, 0, 0, $thumbsX[$i], $thumbsY[$i], $medida[0], $medida[1]);
                        
                        
                        if($this->marcadagua[$i+1] != ''){
                            $watermark_options['watermark'] = $folder . $this->marcadagua[$i+1];
                            // Save watermarked image to file
                            $thumb = $watermark->output($thumb, $folder .$nomeThumb, $watermark_options);
                        }else{
                            imagejpeg($thumb, $folder .$nomeThumb, 100);
                            imagedestroy($thumb);
                        }
                    }
                    
                }elseif($extension == 'png' || $extension == 'pneg'){
                    $imagem = imagecreatefrompng($_FILES['files']['tmp_name']);
                    
                    $isTrueColor = imageistruecolor($imagem);

                    if($isTrueColor){ // Verifica se é truecolor
                        $final  = imagecreatetruecolor( $x, $y );
                        imagealphablending($final, false);
                        imagesavealpha($final  , true );

                    }else{
                        $final  = imagecreate( $x, $y );
                        imagealphablending( $final, false );
                        $transparent = imagecolorallocatealpha( $final, 0, 0, 0, 127 );
                        imagefill( $final, 0, 0, $transparent );
                        imagesavealpha( $final,true );
                        imagealphablending( $final, true );
                    }
                    
                    imagecopyresampled($final, $imagem, 0, 0, 0, 0, $x, $y, $medida[0], $medida[1]);
                    if($this->marcadagua[0] != ''){
                        $watermark_options['watermark'] = $folder . $this->marcadagua[0];
                        // Save watermarked image to file
                        $final = $watermark->output($final, $folder .$novoNome, $watermark_options);
                    }else{
                        imagecopyresampled($final, $imagem, 0, 0, 0, 0, $thumbsX[$i], $thumbsY[$i], $medida[0], $medida[1]);
                        imagepng($final, $folder.$novoNome);
                    }
                    
                    $arquivo = array('nomeOriginal'=>$nomeOriginal, 'novoNome' => $novoNome);
                    
                    for($i = 0; $i < count($thumbsX); $i++){
                        $nomeThumb = $novoNomeWithoutExtension.'_'.$this->tamanhos[($i+1)].'.'.$extension;
                        
                        if($isTrueColor){ // Verifica se é truecolor
                            $thumb  = imagecreatetruecolor( $thumbsX[$i], $thumbsY[$i] );
                            imagealphablending($final, false);
                            imagesavealpha($final  , true );

                        }else{
                            $thumb  = imagecreate( $thumbsX[$i], $thumbsY[$i] );
                            imagealphablending( $final, false );
                            $transparent = imagecolorallocatealpha( $thumb, 0, 0, 0, 127 );
                            imagefill( $thumb, 0, 0, $transparent );
                            imagesavealpha( $thumb,true );
                            imagealphablending( $thumb, true );
                        }
                        
                        if($this->marcadagua[$i+1] != ''){
                            $watermark_options['watermark'] = $folder . $this->marcadagua[$i+1];
                            // Save watermarked image to file
                            $thumb = $watermark->output($thumb, $folder .$nomeThumb, $watermark_options);
                        }else{
                            imagecopyresampled($thumb, $imagem, 0, 0, 0, 0, $thumbsX[$i], $thumbsY[$i], $medida[0], $medida[1]);
                            imagepng($thumb, $folder.$nomeThumb);
                        }

                    }
                }else{
                    $retorno = 'invalido';
                }
                $retorno = $this->tratarArquivo($param = $this->params()->fromRoute('id', 0),$arquivo);
            }
        }
        echo $retorno;
        die();
    }

    /**
     * @return Json of file name
     */
    public function uploadeditorAction(){
        $message = [];
        if ($_FILES['file']['name']) {
            if (!$_FILES['file']['error']) {
                $name = md5(rand(100, 200));
                $ext = explode('.', $_FILES['file']['name']);
                $filename = $name . '.' . $ext[1];
                $destination = getcwd() . '/public/uploads/editor/' . $filename; //change this directory
                $location = $_FILES["file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                $message['resposta'] = $this->request->getBasePath() . '/uploads/editor/' . $filename;//change this URL
            }else{
              $message['resposta'] = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
            }
        }else{
            $message['resposta'] = 'No file!';
        }
        
        return new JsonModel($message);
    }
    
    /**
     * Lista das imagens já enviadas
     */
    public function galeriaeditorAction(){
        echo '<div class="col-md-12"><span class="h4">Clique na imagem desejada:</span></div>';
        $dir = getcwd() . '/public/uploads/editor/';
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if(filetype($dir . $file) == 'file' && $file != '.DS_Store'){
                        $imagePath = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost().$this->request->getBasePath() . '/uploads/editor/' . $file;
                        
                        echo '<div class="col-md-3">'
                        . '     <a href="#" onclick="$(\'.note-image-url\').val(\''.$imagePath.'\'); $(\'.note-image-btn\').removeClass(\'disabled\').removeAttr(\'disabled\')">'
                        . '       <img src="'.$this->request->getBasePath() . '/uploads/editor/' . $file.'">'
                        . '     </a>'
                        . '     <!--<a href="#"><i class="fa fa-trash"></i></a>-->'
                        . '   </div>';
                    }
                }
                closedir($dh);
            }
        }
        die();

    }
}
