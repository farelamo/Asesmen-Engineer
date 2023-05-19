<?php
    namespace App\Services;

    use Exception;
    use App\Models\User;
    use App\Http\Resources\BaseResource;
    use App\Http\Resources\UserCollection;

    class UserService {

        public function returnCondition($condition, $errorCode, $message)
        {
            return response()->json([
                'success' => $condition,
                'message' => $message,
            ], $errorCode);
        }

        public function index()
        {
            try {

                $users = User::select('id', 'fullname', 'username')
                            ->whereNotIn('username', [auth()->user()->username])
                            ->paginate(5);

                return new UserCollection($users);
            }catch(Exception $e){
                return $this->returnCondition(false, 500, 'Internal Service Error');
            }
        }

       public function show($id)
        {
            try {
                
                $user = User::select('id', 'fullname', 'username')
                            ->where('id', $id)
                            ->first();

                if(!$user) return $this->returnCondition(false, 404, 'Data with id ' . $id . ' not found');

                return new BaseResource($user);
            }catch(Exception $e){
                return $this->returnCondition(false, 500, 'Internal Service Error');
            }
        }
    }
?>