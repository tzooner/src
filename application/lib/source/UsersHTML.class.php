<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 25.10.2016
 */


namespace lib\source;


class UsersHTML
{

    public static function printTable(array $table){

        $html = "<table class='table table-bordered'>";

        $html .= "<thead>
                    <tr>
                        <th>Uživatelské jméno</th>
                        <th>E-mail</th>
                        <th>Role</th>          
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>";

        foreach ($table as $row) {

            $html .= "<tr>";

            $html .= sprintf("<td>%s</td>", $row["Username"]);
            $html .= sprintf("<td>%s</td>", $row["Email"]);
            $html .= sprintf("<td>%s</td>", $row["RoleName"]);
            $html .= sprintf("<td class='ac'><a href='index.php?page=user_edit&id=%d'><span class='glyphicon glyphicon-pencil text-warning'></span></a></td>", $row["UserID"]);
            $html .= sprintf("<td class='ac'><span class='glyphicon glyphicon-remove text-danger hover remove-item' data-id='%d' data-type='user'></span></td>", $row["UserID"]);

            $html .= "</tr>";

        }

        $html .= "</tbody></table>";

        return $html;

    }

    public static function printUsersCombo(array $users, $selectedUsersID = array()){

        $usersID = array();
        foreach ($selectedUsersID as $user) {
            $usersID[] = $user["UserID"];
        }

        $html = "<select id='UserID_FK' name='UserID_FK[]' class='form-control validate-required' multiple>";
        foreach ($users as $user) {

            $userID = $user["UserID"];

            $selected = "";
            if(in_array($userID, $usersID)){
                $selected = "selected='selected'";
            }

            $html .= sprintf("<option value='%d' %s>%s (%s)</option>", $userID, $selected, $user["Username"], $user["Email"]);
        }
        $html .= "</select>";

        return $html;

    }

    public static function printRoleCombo(array $roles, $selectedRoleID = ""){

        $html = "<select id='RoleID_FK' name='RoleID_FK' class='form-control validate-required'>";
        $html .= "<option value='0'></option>";
        foreach ($roles as $role) {

            $roleID = $role["RoleID"];

            $selected = "";
            if(intval($selectedRoleID) > 0 && $roleID == $selectedRoleID){
                $selected = "selected='selected'";
            }

            $html .= sprintf("<option value='%d' %s>%s (%s)</option>", $roleID, $selected, $role["Name"], $role["Description"]);
        }
        $html .= "</select>";

        return $html;

    }


}