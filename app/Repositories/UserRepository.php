<?php
/*
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-05-28
 * Time: 17:58
 */

namespace App\Repositories;


use App\User;

/*
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository
{
	/*
	 * @param $id
	 * @return mixed
	 */
	public function byId($id)
	{
		return User::find($id);
	}
}