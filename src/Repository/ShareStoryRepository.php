<?php

namespace App\Repository;

use App\Entity\SchduleEntity;

/**
 * ShareStoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ShareStoryRepository extends \Doctrine\ORM\EntityRepository
{

    public function ajax_list(array $get, $userData){

      
 

        $columns = array(
            array('sd.`schedule_type`', "sd.`schedule_type`", "scheduleDesc"),
            array('CONCAT(us.`first_name` , " ", us.`last_name`)', 'CONCAT(us.`first_name` , " ", us.`last_name`)', 'sharer'),
            array('ss.`id`', "ss.`id`"),
            array('s.`id`', "s.`id`" , "storyId"),
        );
        

        $asColumns = array();

        $select = "SELECT";
        $from = "FROM `share_story` ss";
        $sqlWhere = " WHERE ss.`is_deleted` = 0 AND ss.`user_id` = ".$userData['id']." AND s.`is_deleted` = 0";
        $joins = " LEFT JOIN `user` u ON u.`id` = ss.`user_id`";
        $joins .= " LEFT JOIN `story` s ON s.`id` = ss.`story_id`";
        $joins .= " LEFT JOIN `schedule` sd ON sd.`id` = s.`schedule_id`";
        $joins .= " LEFT JOIN `user` us ON sd.`user_id` = us.`id`";


        $groupBy = "";
        $orderBy = " ORDER BY ss.`id` DESC";
        $limit = "";
        $stmtParams = array();

        foreach($columns as $key => $column) {
            $select .= ($key > 0 ? ', ' : ' ') . $column[1] . (isset($column[2]) ? ' AS ' . $column[2] : '');
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
            $storyId = base64_encode($row['storyId']);
  
            $values = array(
                $row['scheduleDesc'],
                $row['sharer'],
                "<a href='/story/telling/".$storyId."' class='button action-button-success'>View</a>" . "<a href='javascript:void(0)' data-id='". base64_encode($row['id'])."' data-action='d' class='button btn-delete action-button-danger'>Delete</a>"
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
                         c.`user_id` IS NOT NULL THEN CONCAT(u.`first_name`, ' ', u.`last_name`, '(', u.`email` , ')')
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
            AND c.`share_story_id` = ".$id."
            ORDER BY c.`created_at` DESC
            ".$limit."
        ");

  
       
        $res = $query->executeQuery();
        $result = $res->fetchAllAssociative();
        return $result;
    }

   
   
}
