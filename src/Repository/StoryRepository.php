<?php

namespace App\Repository;

use App\Entity\SchduleEntity;

/**
 * StoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StoryRepository extends \Doctrine\ORM\EntityRepository
{

    public function ajax_list(array $get, $userData){

      
 

        $columns = array(
            array('sc.`schedule_type`', "sc.`schedule_type`", "storyType"),
            array('sc.`calendar`', "sc.`calendar`", 'interviewer'),
            array('s.`id`', "s.`id`"),
        );
        

        $asColumns = array();

        $select = "SELECT";
        $from = "FROM `story` s";
        $sqlWhere = " WHERE s.`is_deleted` = 0";
        $joins = " LEFT JOIN `schedule` sc ON sc.`id` = s.`schedule_id`";
        $joins .= " LEFT JOIN `user` u ON u.`id` = sc.`user_id`";
        $groupBy = "";
        $orderBy = " ORDER BY s.`id` DESC";
        $limit = "";
        $stmtParams = array();

        foreach($columns as $key => $column) {
            $select .= ($key > 0 ? ', ' : ' ') . $column[1] . (isset($column[2]) ? ' AS ' . $column[2] : '');
        }

        if(isset($userData['type']) && $userData['type'] == 'Client'){
            $stmtParams['clientId'] = $userData['id'];
            $sqlWhere.= ' AND sc.`user_id` = :clientId';
        }


        // /*
        //  * Ordering
        //  */
        // foreach($get['columns'] as $key => $column) {
        //     if($column['orderable']=='true') {
        //         if(isSet($get['order'])) {
        //             foreach($get['order'] as $order) {
        //                 if($order['column']==$key) {
        //                     $orderBy .= (!empty($orderBy) ? ', ' : 'ORDER BY ') . $columns[$key][0] . (!empty($order['dir']) ? ' ' . $order['dir'] : '');
        //                 }
        //             }
        //         }
        //     }
        // }

        /*
         * Filtering
         */
        if(isset($get['search']) && $get['search']['value'] != ''){
            $aLikes = array();
            foreach($get['columns'] as $key => $column) {
                if($column['searchable']=='true') {
                    $aLikes[] = $columns[$key][0] . ' LIKE :searchValue';
                }
            }
            foreach($asColumns as $asColumn) {
                $aLikes[] = $asColumn . ' LIKE :searchValue';
            }
            if(count($aLikes)) {
                $sqlWhere .= (!empty($sqlWhere) ? ' AND ' : 'WHERE ') . '(' . implode(' OR ', $aLikes) . ')';
                $stmtParams['searchValue'] = "%" . $get['search']['value'] . "%";
            }
        }

        /* Set Limit and Length */
        if(isset( $get['start'] ) && $get['length'] != '-1'){
            $limit = 'LIMIT ' . (int)$get['start'] . ',' . (int)$get['length'];
        }

        $sql = "$select $from $joins $sqlWhere $groupBy $orderBy";
        $query = $this->getEntityManager()->getConnection()->prepare($sql);
     

        foreach($stmtParams as $k => $v){
            $query->bindValue($k, $v);

        }
        $res = $query->executeQuery();
        $result_count = $res->fetchAllAssociative();
        $sql = "$select $from $joins $sqlWhere $groupBy $orderBy $limit";
        $query = $this->getEntityManager()->getConnection()->prepare($sql);
        foreach($stmtParams as $k => $v){
            $query->bindValue($k, $v);

        }
        $res = $query->executeQuery();
        $result = $res->fetchAllAssociative();

        /* Data Count */
        $recordsTotal = count($result_count);

        /*
         * Output
         */
        $output = array(
            "draw" => intval($get['draw']),
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsTotal,
            "data" => array()
        );

        $url = $get['url'];
        $formUrl = '';
        foreach($result as $row) {

            $id = base64_encode($row['id']);
  
            $values = array(
                $row['storyType'],
                $row['interviewer'],
                "<a href='/story/details/".base64_encode($row['id'])."' class='button action-button-success'>View</a> " . "<a href='javascript:void(0)' data-id='". base64_encode($row['id'])."' data-action='d' class='button btn-delete action-button-danger'>Delete</a>"
 
            );
            
        
            $output['data'][] = $values;
        }

        unset($result);

        return $output;
    }

    public function comment_ajax_list(string $id, $userData) {

       
        $limit = "LIMIT 0,20";
        $query = $this->getEntityManager()->getConnection()->prepare("
            SELECT
                CASE 
                    WHEN
                         c.`user_id` IS NOT NULL THEN CONCAT(u.`first_name`, ' ', u.`last_name`)
                    ELSE 
                        CONCAT(c.`guest_name`, '(' , c.`email` , ')')
                    END AS commentUser,
                CASE 
                    WHEN
                         u.`profile_photo_desc` IS NOT NULL THEN CONCAT('/uploads/profile_photo/', u.`parsed_profile_photo_desc`)
                    ELSE 
                        '/assets/img/default-profile-pic.jpg'
                    END AS profilePic,   
                c.`message`,
               DATE_FORMAT(c.`created_at`, '%Y-%m-%d H:i:s') AS createdAt    
            FROM `comment` c
            LEFT JOIN `user` u ON u.`id` = c.`user_id`
            WHERE c.`is_deleted` != 1
            AND c.`story_id` = ".$id."
            ORDER BY c.`created_at` DESC
            ".$limit."
        ");

  
       
        $res = $query->executeQuery();
        $result = $res->fetchAllAssociative();
        return $result;
    }

    public function getLikeCtr(string $id) {

        $id = base64_decode($id);
        $query = $this->getEntityManager()->getConnection()->prepare("
            SELECT
                COUNT(sl.`id`) AS ctr,
                sli.likers
            FROM `story_like` sl
            LEFT JOIN (
                SELECT 
                    GROUP_CONCAT(CONCAT(u.`first_name` , ' ', u.`last_name`)) AS likers,
                    sli.`story_id`
                FROM `story_like` sli
                LEFT JOIN `user` u ON u.`id` =  sli.`user_id`
                WHERE (sli.`is_deleted` != 1 OR sli.`is_deleted` IS NULL)
                GROUP BY sli.`story_id`
            ) sli ON sli.`story_id` = ".$id."
            WHERE (sl.`is_deleted` != 1 OR sl.`is_deleted` IS NULL)
            AND sl.`story_id` = ".$id."
        ");

  
       
        $res = $query->executeQuery();
        $result = $res->fetchAllAssociative();

        $result = ($result ? ($result[0] != NULL ? $result[0] : 0) : 0);
        return $result;
    }

    public function getCommentCtr(string $id) {

        $id = base64_decode($id);
        $query = $this->getEntityManager()->getConnection()->prepare("
            SELECT
                COUNT(c.`id`) AS ctr
            FROM `comment` c
            WHERE (c.`is_deleted` != 1 OR c.`is_deleted` IS NULL)
            AND c.`story_id` = ".$id."
        ");

  
       
        $res = $query->executeQuery();
        $result = $res->fetchAllAssociative();
        $result = ($result ? ($result[0]['ctr'] != NULL ? $result[0]['ctr'] : 0) : 0);
        return $result;
    }

    public function getPageList($userData, $q){

        $orderBy = '';
        $andWhere = '';
        
        if(isset($q['orderBy'])){
            if($q['orderBy'] == 'date'){
                $orderBy .= "ORDER BY sc.`date_created` DESC"; 
            } else {
                $orderBy .= "ORDER BY sc.`schedule_type` ASC";
            }
        }

        if(isset($q['ids']) && !empty($q['ids'])){
           $andWhere .= ' AND s.`id` NOT IN  (' . $q["ids"]. ')';
        }

        if(isset($q['isPublic']) && $q['isPublic'] == 'true'){
            $andWhere .= ' AND s.`is_public` = 1';
        }

        if(isset($q['q']) && $q['q'] != ''){
            $andWhere .= ' AND (s.`title` LIKE "%'.$q['q'].'%" OR CONCAT(u.`first_name` , " ", u.`last_name`) LIKE "%'.$q['q'].'%" )';
        }


        if(isset($q['page']) && $q['page'] == 'my_story'){
            $andWhere .= "  AND (
                sc.`user_id` = ".$userData['id']." 
             )";
        } else {
            if(isset($q['filterBy']) && $q['filterBy'] != 'all'){

                if($q['filterBy'] == 'only_shared_story' ){
                    $andWhere .= "  AND 
                           s.`id` IN (
                            SELECT 
                                GROUP_CONCAT(ss.`story_id`)
                            FROM `share_story` ss
                            LEFT JOIN `story` s ON s.`id` = ss.`story_id`
                            LEFT JOIN `schedule` sc ON sc.`id` = s.`schedule_id`
                            WHERE s.`is_public` = 1 
                            AND ss.`user_id` = ".$userData['id']." 
                            GROUP BY ss.`user_id` 
                        )
                    ";
    
                } else {
                    $andWhere .= "  AND (
                            sc.`user_id` = ".$userData['id']." 
                    )";
                }
              
            }
        }

     

        $query = $this->getEntityManager()->getConnection()->prepare("
            SELECT
                s.`parsed_file_desc` AS storyImg,
                s.`title` AS storyTitle,
                DATE_FORMAT(sc.`date_created`, '%b %d, %Y ') AS createdDate,
                s.`id` AS storyId,
                s.`is_public` AS isPublic,
                sv.storyViewCtr AS storyViewCtr,
                (CASE
                    WHEN sc.`user_id` !=  ".$userData['id']."  THEN 1
                    ELSE 0
                END) AS isShared
            FROM `story` s
            LEFT JOIN `schedule` sc ON sc.`id` = s.`schedule_id`
            LEFT JOIN `user` u ON u.`id` = sc.`user_id`
            LEFT JOIN (
                SELECT 
                    sv.`story_id`,
                    COUNT(sv.`id`) AS storyViewCtr
                FROM `story_view` sv
                GROUP BY sv.`story_id`
            ) sv ON sv.`story_id` = s.`id`
            WHERE   (s.`is_deleted` != 1 OR s.`is_deleted` IS NULL)
            ".$andWhere."
            ".$orderBy."
            LIMIT 6
        ");


       
        $res = $query->executeQuery();
        $result = $res->fetchAllAssociative();
    
        return $result;
    }


   
   
}
