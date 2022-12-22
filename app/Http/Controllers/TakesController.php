<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TakesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //biến $data này dùng để chứa các biến khác
        //nó sẽ truyền data từ controller đến View.
        $data = [];
        //Tu moi cmts
        //Tạo ra 1 biến
        $name = 'my name is Tom.';
        //gán giá trị của biến $name cho $data với key là name
        $data['name'] = $name;
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
        return view('tasks.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //biến $data này dùng để chứa các biến khác
        //nó sẽ truyền data từ controller đến View.
        $data = [];

        // đứng ở đây và gọi đến model để lấy ra 1 thông tin chi tiết của 1 task
        //..
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
        return view('tasks.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Logic: Kiểm tra xem $id này có tồn tại trong DB chưa ? (table tasks)
        // Nếu chưa có thì thông báo lỗi
        // Nếu đã có rồi thì tiến hành xử lí xóa record này ra khỏi table tasks
        // Dùng redirect để di chuyển về trang Tasks List + thông tin chi tiết
        //dd($id);
        // with: session flash chỉ tồn tại 1 lần và f5 thì biến mất
        return redirect(route('tasks.index'))->with('success','Xóa thành công.');
        //return redirect(route('tasks.index'))->with('error','Xóa thất bại.');
    }
}
