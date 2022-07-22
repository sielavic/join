if (is_array($post['watcher'])) {
                    $watchers ='';
                    foreach ($post['watcher'] as $key=>$watcher) {
                        if ($key == 0){
                            $watchers .= 'wu.wus_user_id = '. $watcher  ;
                        }else{
                            $watchers .= ' OR w1.wrk_id = wu.wus_wrk_id and  wu.wus_user_id= '. $watcher  ;
                        }
                    }
                    $this->db->join('(SELECT
        w1.wrk_macrotaskid as mtid,   
        GROUP_CONCAT(wu.wus_user_id SEPARATOR \',\') as wtchrs_ids
    FROM work w1         
    LEFT JOIN work_user wu ON
        w1.wrk_id = wu.wus_wrk_id and '.$watchers.'
        inner JOIN work_user_watcher wuw on wuw.wuw_wus_id = wu.wus_id
        where w1.wrk_type=\'task\'
    group by w1.wrk_id) as wtchrs', 'multitask.id = wtchrs.mtid', 'inner');
                }else{
                    $this->db->join('(SELECT
        w1.wrk_macrotaskid as mtid,   
        GROUP_CONCAT(wu.wus_user_id SEPARATOR \',\') as wtchrs_ids
    FROM work w1         
    LEFT JOIN work_user wu ON
        w1.wrk_id = wu.wus_wrk_id and wu.wus_user_id = '.$post['watcher'].'
        inner JOIN work_user_watcher wuw on wuw.wuw_wus_id = wu.wus_id
        where w1.wrk_type=\'task\'
    group by w1.wrk_id) as wtchrs', 'multitask.id = wtchrs.mtid', 'inner');
                }
