<?php
    class StoredProcedureBehavior extends ModelBehavior {
    
    /**
     * execute a stored proc. Call executeMssqlSp to not confuse with the cake execute
     * Taken initially from: http://planetcakephp.org/aggregator/items/4390-cakephp-calling-oracle-stored-procedures-and-functions 
     *
     * @param object $Model instance of model
     * @param string $name stored procedure name e.g. run_validation_algorithms_sp
     * @param array $inParams name=>value array of IN params, $type is assigned based on the php variable type
     * @param array $outParams name=>type array of OUTPUT params, 
     *                            e.g. array('algorithm_id' => SQLINT4, 'RETVAL' => SQLVARCHAR).
     *                            $type: SQLTEXT, SQLVARCHAR, SQLCHAR, SQLINT1, SQLINT2, SQLINT4, SQLBIT, SQLFLT4, SQLFLT8, SQLFLTN
     *@return array $output = array('results' => array(), 'params' => $outParams), $outParams has type replaced with the output value
     */
        function executeMssqlSp(&$Model, $name, $inParams, $outParams = array()) {
            
            $sqlstr="CALL ".$name."(";
            foreach ($inParams as $parm=>$value){
                $sqlstr=($parm==0)?$sqlstr.$value:$sqlstr.",".$value;
            }
            $sqlstr=$sqlstr.")";
            $result=$Model->query($sqlstr);
           return $result;
        }
    }
    ?>