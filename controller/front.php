<?php
require_once "model/chapitremodel.php";
require_once "view/view.php";
require_once "controller/post.php";
require_once "controller/comment.php";

class Front
{
    private $chapitremodel;

    public function __construct($uri)
    {
        $this->chapitremodel = new ChapitreModel();
    
        switch ($uri[0]) {
            case "quisuisje":
                $this->biographie();
                break;
            case "chapitre":
                $this->chapitre(array_slice($uri, 1));
                break;
            case "chapitres":
                $this->chapitres();
                break;
            default:
                $this->accueil();
                break;
        }
        
        $content = [
            "{{ content }}"=>$this->html,
            "{{ title }}"=>$this->title,
            ];

        $view = new View($content, "index");
        $this->html = $view->html;
    }

    private function biographie()
    {
        $this->html = file_get_contents("template/biographie.html");
        $this->title = "Qui je suis ?";
    }

    private function chapitre($uri)
    {
        if (empty($uri)) {
            global $config;
            header("Location: /".$config['directory']);
        }
        if ($uri[0]==="") {
            global $config;
            header("Location: /".$config['directory']);
        }

        $slug = $uri[0];
        $chapitre = new Post();
        $comment = new Comment();
        if (isset($uri[1])) {
            $comment->reportComment($uri[1]);
        }
        $content = $chapitre->showSinglePost($slug);
        $content .= $comment->countValidateComment($chapitre->idPost);
        $content .= $comment->showValidateComment($chapitre->idPost);
    

        global $safeData;
        if (!is_null($safeData->post["author"])) {
            $comment->addComment($safeData->post["author"], $safeData->post["comment"], $chapitre->idPost);
            header("Location: #");
        }
        
        $this->html = $content;
        $this->title = $chapitre->title;
    }

    private function chapitres()
    {
        $chapitres = new Post();
        $content = $chapitres->showListPost();
        $this->html = $content;
        $this->title = "Tous les chapitres";
    }

    private function accueil()
    {
        $home = new Post();
        $content = $home->showFeaturedPost();
        $this->html = $content;
        $this->title = "La nouvelle histoire de Jean Forteroche";
    }
    
    private function signalerCommentaire($idComment)
    {
        $comment = new Comment();
        $comment->reportComment($idComment);
    }
}
