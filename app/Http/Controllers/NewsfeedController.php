<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Awjudd\FeedReader\Facade as fReader;


class NewsfeedController extends Controller
{
    //
	
	
	public function getNewsPapperList(){	
	
		$status = "200";
		$returnData = "";
		$startingSoonData = "";
		$errorFlag = false;			

		
		try {		
			
			$returnData = DB::table('tbl365_paper_rss_list')					   
						->where([ ['active_status', 'yes'] ])
						->get();
						
			
		} catch(\Exception $e){	
		
					
		}
		
		$retArray = array(    				
    				'papperlist' => $returnData,					
					'error' => $errorFlag					
				);
		
		return response()->json($retArray);
	   
	}
	
	public function getNewsCategoryList(){	
	
		$status = "200";
		$returnData = "";
		$startingSoonData = "";
		$errorFlag = false;			

		
		try {		
			
			$returnData = DB::table('tbl365_paper_category')					   
						->where([ ['active_status', 'yes'] ])
						->get();
						
			
		} catch(\Exception $e){	
		
					
		}
		
		$retArray = array(    				
    				'categorylist' => $returnData,					
					'error' => $errorFlag					
				);
		
		return response()->json($retArray);
	   
	}
	
	public function getNewsByCategoryID($catID){	
	
	    global $fReader;
		
		$status = "200";
		$returnData = "";
		$startingSoonData = "";
		$errorFlag = false;			
        $arrListFeeds = [];
		$arrEmptyArray = [];
		
		try {		
			
			$returnData = DB::table('tbl365_paper_category_rssfeed_url')					   
						->where([ ['active_status', 'yes'],
							['category_id', $catID]
						 ])
						->get();
						
			//$content = file_get_contents('http://www.dinakaran.com/rss_news.asp?id=9');
            $content = fReader::read('http://www.dinakaran.com/rss_news.asp?id=9');
			$itemarr = $content->get_items();
			//print_r($content->get_items(0, 5));
			foreach($itemarr as $item){
			
			    $indiFeeds = (object) $arrEmptyArray;
				$indiFeeds->title = $item->get_title();
				$indiFeeds->flink = $item->get_permalink();
				$indiFeeds->sdescription = $item->get_description();
				$arrListFeeds[] = $indiFeeds;			
			  
			}
			
			
		} catch(\Exception $e){	
		//echo $e->getMessage();
		//die;
		//$errorFlag = true;	
					
		}
		
		$retArray = array(    				
    				'categorylist' => $arrListFeeds,					
					'error' => $errorFlag					
				);
		
		return response()->json($retArray);
	   
	}
}
