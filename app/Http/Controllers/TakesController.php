<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TakesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Storega::delete());
        //cách 1: Sử dụng Query Builder
        // $tasks = DB::table('tasks')->get();// method get lấy ra tất cả các record
        // $tasks = DB::table('tasks')->paginate(10);//method paginate(10): phân trang và hiển thị ra 10 record trong 1 trang
        
        
        // Cách 2: Sử Dụng Eloquent
        // $tasks =Task::get();
        $tasks =Task::with('user')
        ->paginate(10);//method paginate(10): phân trang và hiển thị ra 10 record trong 1 trang
        // dd($tasks);
        // ->orderBy('id', 'desc')
        
        $data['tasks'] = $tasks;
        return view('tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //biến $data này dùng để chứa các biến khác
        //nó sẽ truyền data từ controller đến View.
        $data = [];

        // Lấy ra tất cả danh sách User 
        $users = User::all() // method all() lấy ra tất cả User
        ->pluck('name', 'id') // method pluck('name', id) : lấy ra 2 column trong table User đó là id, name
        ->toArray(); // method toArray(): convert object sang Array
        // gửi data['user'] = $users;
        $data['users'] = $users;
        // dd($data);
        return view('tasks.create', $data);
        //return view('tasks.create', compact('users'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {   
        // class Request là lớp mặc định
        // class StoreTaskRequest là lớp mình tạo
        //ra để validate (khi người dùng submit)


        // class StoreTaskRequets được gọi là Injecting (nhúng vào 1 function)
        // khi sử dụng Injecting này thì chúng ta sẽ tạo 1 đói tượng (object)
        //từ 1 class có sẵn (StoreTaskRequets)
        //dd($request->_token);
        // StoreTaskRequest: function store() sẽ ưu tiên số 1 là kiểm duyệt data
        // trước khi xử lý logic ở bên trong hàm store()
        
        //dd($request->all());

        // Tạo ra 1 biến để lưu data vào table tasks 
        $dataSave = [
            'name'=>$request->input('name'), // Cách 1
            //'name'=>$request->get('name'), // Cách 2
            //'name'=>$request->name, // Cách 3
            'user_id' => $request->input('user_id'),

        ];

        // xử lý upload file image
        // kiểm tra xem có upload file lên không?
        // if($request->hasFile('image') && $request->file('image')->isValid()) {
        //     // method hasFile(): trả về true nếu gửi lên 1 hình ảnh.
        //     // method isValid(): trả về true nếu hình ảnh hợp lệ

        //     $extension = $request->image->extension();
        //     $fileName = 'image_' . time() . '.' . $extension;
        //     $request->image->storeAs('public/images', $fileName);

        //     // Add '/storage/ vào $imagePath
        //     $imagePath = '/storage/images' . $fileName;

        //     // Add image vào biến $dataSave // cách 1: add thêm storage
        //     $dataSave['image'] = $imagePath;

        // }

        // Xử lý upload file image
        // kiểm tra xem có upload file lên không ?
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // method hasFile() : trả về true nếu gửi lên 1 hình ảnh.
            // method isValid() : trả về true nếu hình ảnh hợp lệ.

            $extension = $request->image->extension();
            $fileName = 'image_' . time() . '.' . $extension;
            $request->image->storeAs('images', $fileName, ['disk'=>'public']);

            // add '/storage/' vào $imagePath
            $imagePath = '/storage/images/' . $fileName;

            // Add image vào biến $dataSave // case 1: add thêm storage
            $dataSave['image'] = $imagePath;

            // Case 2: không add thêm storage thì ngoài view (views/tasks/index.blade.php)
            // <img src="{{ Storage::assert() }}" alt="">
        }

       
        // Tạo ra 1 biến để lưu data vào table tasks 
        // $dataSave = $request->only(['name', 'user_id'])
        try {
            // Save Database
            Task::create($dataSave);
            
            // Lưu thành công vào DB rồi thì di chuyển
            // về trang danh sách Task và thông báo thành công vào
            return redirect()->route('tasks.index')->with('success', 'Thêm mới thành công');
        }catch(Exception $exception){
            //Ngược lại, ở đây có lỗi xảy ra thì quay về trang danh sách Task
            // và thông báo lỗi đã xảy ra
            return redirect()->route('tasks.index')->with('success', 'Thêm mới thất bại.
            Lý do:'. $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function show(Task $task) // cách 1 Injecting 1 class
    public function show($id) // cách 2 (normal)
    {
        // dd($task);
        //biến $data này dùng để chứa các biến khác
        //nó sẽ truyền data từ controller đến View.
        $data = [];

        // đứng ở đây và gọi đến model để lấy ra 1 thông tin chi tiết của 1 task
        //$task = Task::with('user')->find($id); //cách 1
        $task = Task::with('user')->findOrFail($id); // cách 2
        // method find($id) : $id tương đương với column id của table tasks_seeder
        // method find() : dùng để lấy ra 1 record duy Nhất
        //nếu tìm thấy thì trả về object
        // người lại không tìm thấy thì trả về nullable

        // method findOrFali($id): $id tương đương với column id của tanle tasks 
        // method findOrFali(): dùng để lấy ra 1 record duy Nhất
        // nhưng nếu $id không tồn tại trong mysql (không tông tại trong table tasks)
        //thì nó sẽ báo lỗi
        //dd($task);
        // Truyền $task qua View để hiển thị
        $data['task'] = $task;
        return view('tasks.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //biến $data này dùng để chứa các biến khác
        //nó sẽ truyền data từ controller đến View.
        $data = [];

        // đứng ở đây và gọi đến model để lấy ra 1 thông tin chi tiết của 1 task
        //$task = Task::with('user')->find($id); //cách 1
        $task = Task::findOrFail($id); // cách 2
        // method find($id) : $id tương đương với column id của table tasks_seeder
        // method find() : dùng để lấy ra 1 record duy Nhất
        //nếu tìm thấy thì trả về object
        // người lại không tìm thấy thì trả về nullable

        // method findOrFali($id): $id tương đương với column id của tanle tasks 
        // method findOrFali(): dùng để lấy ra 1 record duy Nhất
        // nhưng nếu $id không tồn tại trong mysql (không tông tại trong table tasks)
        //thì nó sẽ báo lỗi
        
        // Truyền $task qua View để hiển thị
        $data['task'] = $task;

        // Lấy ra tất cả danh sách User 
        $users = User::all() // method all() lấy ra tất cả User
        ->pluck('name', 'id') // method pluck('name', id) : lấy ra 2 column trong table User đó là id, name
        ->toArray(); // method toArray(): convert object sang Array
        // gửi data['user'] = $users;
        $data['users'] = $users;

        return view('tasks.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        // Sử dụng method FindOrFail để lấy ra record tương ứng với $id
        $task = Task::findOrFail($id);

        // Set value cho các column mong muốn update vào table tasks
        $task->name = $request->input('name');
        $task->user_id = $request->input('user_id');

        $oldImage = null;

         // Xử lý upload file image
        // kiểm tra xem có upload file lên không ?
        if ($request->hasFile('new_image') && $request->file('new_image')->isValid()) {
            // method hasFile() : trả về true nếu gửi lên 1 hình ảnh.
            // method isValid() : trả về true nếu hình ảnh hợp lệ.

            $extension = $request->new_image->extension();
            $fileName = 'image_' . time() . '.' . $extension;
            // Case 1: sử dụng storeAs
            // $request->image->storeAs('public/images', $fileName); // case 1.1: không khai báo disk (disk default là local)
            $request->new_image->storeAs('images', $fileName, ['disk' => 'public']); // case 1.2: khai báo disk = public

            // add '/storage/' vào $imagePath
            $imagePath = '/storage/images/' . $fileName;
            
            // gán giá trị hiện tại cho column tasks.image
            $oldImage = $task->image;

            // update đường dẫn mới cho image
            $task->image = $imagePath;

            // Case 2: không add thêm storage thì ngoài view (views/tasks/index.blade.php)
            // <img src="{{ Storage::assert() }}" alt="">

        }


        try{
            // Dùng method save() để thực hiện  update data xuống MySQL
            $task->save();

            if(!is_null($oldImage)){
                // $oldImage = str_replace('/storage/','',$oldImage);
                if(File::exists(public_path($oldImage))){
                    File::delete(public_path($oldImage));
                }
            }
            return redirect()->route('tasks.index')
            ->with('success', 'Cập nhật thành công');
        } catch (Exception $exception) {
            return redirect()->route('tasks.index')
            ->with('error', 'Cập nhật thất bại. Lý do' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id) //cách 1 normal
    // {
    //     // Logic: Kiểm tra xem $id này có tồn tại trong DB chưa ? (table tasks)
    //     // Nếu chưa có thì thông báo lỗi
    //     // Nếu đã có rồi thì tiến hành xử lí xóa record này ra khỏi table tasks
    //     // Dùng redirect để di chuyển về trang Tasks List + thông tin thành công

    //     // lấy ra 1 record với id = $id truyền vào
    //     // SQL: select * from tasks where id = $id limit 1;
    //     // method findOrFail() khi thực thi nếu ko tìm thấy record thì báo lỗi
    //     // ngược lại thì chúng lấy được 1 object
    //     $task = Task::findOrFail($id);
        
    //     try {
    //         //method delete(): Dùng để xóa 1 record ra khỏi table tasks
    //         // Lưu ý nếu $task không phải là 1 object (model Task) 
    //         // thì khi thục thi lệnh delete() nó sẽ báo lỗi.
    //         $task->delete();

    //         // with: session flash chỉ tồn tại 1 lần và f5 thì biến mất
    //         return redirect( route('tasks.index'))->with('success', 'xóa thành công');
    //     } catch (Exception $exception) {

    //         // with: session flash chỉ tồn tại 1 lần và f5 thì biến mất
    //         return redirect(route('tasks.index'))->with('error','Xóa thất bại.' . $exception->getMessage());
    //         //return redirect(route('tasks.index'))->with('error','Xóa thất bại.');
    //     }
        
    // }

    public function destroy(Task $task) //cách 2 
    {
        // Logic: Kiểm tra xem $id này có tồn tại trong DB chưa ? (table tasks)
        // Nếu chưa có thì thông báo lỗi
        // Nếu đã có rồi thì tiến hành xử lí xóa record này ra khỏi table tasks
        // Dùng redirect để di chuyển về trang Tasks List + thông tin thành công

        // lấy ra 1 record với id = $id truyền vào
        // SQL: select * from tasks where id = $id limit 1;
        // method findOrFail() khi thực thi nếu ko tìm thấy record thì báo lỗi
        // ngược lại thì chúng lấy được 1 object
        //$task = Task::findOrFail($id);

            $oldImage = $task->image;

        try {
            //method delete(): Dùng để xóa 1 record ra khỏi table tasks
            // Lưu ý nếu $task không phải là 1 object (model Task) 
            // thì khi thục thi lệnh delete() nó sẽ báo lỗi.
            $task->delete();

            //xóa hình ảnh cũ
            if(!is_null($oldImage)){
                // $oldImage = str_replace('/storage/','',$oldImage);
                if(File::exists(public_path($oldImage))){
                    File::delete(public_path($oldImage));
                }
            }

            // with: session flash chỉ tồn tại 1 lần và f5 thì biến mất
            return redirect( route('tasks.index'))->with('success', 'xóa thành công');
        } catch (Exception $exception) {

            // with: session flash chỉ tồn tại 1 lần và f5 thì biến mất
            return redirect(route('tasks.index'))->with('error','Xóa thất bại.' . $exception->getMessage());
            //return redirect(route('tasks.index'))->with('error','Xóa thất bại.');
        }
        
    }
}
