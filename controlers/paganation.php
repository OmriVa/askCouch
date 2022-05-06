<?php



function getPaginationNav($page,$param,$displayPerPage,$totalCount){
    //nim page number = 1
    if($page < 1){
        $page = 1;
    }
    $dataCount =$totalCount;
    $displayRows = $displayPerPage;
    //round up the page number.
    $pages = ceil($dataCount / $displayRows);
    //if pagenumber greater then the last page display last page.
    if($page > $pages){
        $page = $pages;
    }
    $temp = $page;
    
    $div = "";
    $div .= '<nav aria-label="Page navigation example">';
    $div .= '<ul class="pagination justify-content-center ">';
    $temp--;
    if($temp < 1)
    {
        $div .= '<li class="page-item disabled "><a class="page-link text-info" href="?'.$param.'='.$temp.'">הקודם</a></li>';
    }else{
        $div .= '<li class="page-item "><a class="page-link text-info" href="?'.$param.'='.$temp.'">הקודם</a></li>';
    }
    $temp++;
    if($temp>=$pages){   
        $temp = $temp-$pages;
    }
    for($i=0;$i<3;$i++)
    {
    if($temp<$pages && $temp > 0){   
        if($temp == $page)
        {
            $div .= '<li class="page-item"><a class="page-link active-color" href="?'.$param.'='.$temp.'">'.$temp.'</a></li>';
        }else{
            $div .= '<li class="page-item"><a class="page-link text-info" href="?'.$param.'='.$temp.'">'.$temp.'</a></li>';
        }
    }
        $temp = $temp + 1;
    }
    $div .= '<li class="page-item disabled "><a class="page-link text-info" href="#" >...</a></li>';
    if($page>=$pages){
        $div .= '<li class="page-item"><a class="page-link active-color" href="?'.$param.'='.$pages.'">'.$pages.'</a></li>';
    }else{
        $div .= '<li class="page-item"><a class="page-link text-info" href="?'.$param.'='.$pages.'">'.$pages.'</a></li>';
    }
    $temp = intval($page) + 1;
    if($temp > $pages){
        $div .= '<li class="page-item disabled">';
    }else{
        $div .= '<li class="page-item ">';
    }
    $div .= '<a class="page-link text-info" href="?page='.$temp.'">הבא</a>';
    $div .= '</li>';
    $div .= '</ul>';
    $div .= '</nav>';
    echo $div;
}

?>
