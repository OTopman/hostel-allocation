package com.app.hostelallocation;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Context;
import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.view.WindowManager;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Spinner;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.bottomsheet.BottomSheetDialog;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class Main extends AppCompatActivity {

    FloatingActionButton student;
    ImageButton home,change_password;
    private BottomSheetDialog mBottomSheetDialog,bottomSheetDialog;

    SharedPreferences sharedPreferences;
    public String response,student_id;

    public List<Lists> mData = new ArrayList<>();
    public RecyclerView recyclerView;
    public ListAdapters listAdapters;

    Button submit_change_password;
    EditText npassword,password;

    public Func func;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        sharedPreferences = getSharedPreferences("ALL_USER_INFO", Context.MODE_PRIVATE);
        response = sharedPreferences.getString("all_user_info", null);

        try {

            JSONObject object = new JSONObject(response);
            JSONObject student_info = object.getJSONObject("student_info");
            student_id = student_info.getString("id");

        }catch (JSONException e){
            e.printStackTrace();
        }

        student = findViewById(R.id.student);
        home = findViewById(R.id.home);
        change_password = findViewById(R.id.change_password);

        func = new Func(this);

        getSupportFragmentManager().beginTransaction().replace(R.id.container, new Dashboard()).addToBackStack(null).commit();

        student.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                bottomSheet();
            }
        });

        home.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                getSupportFragmentManager().beginTransaction().replace(R.id.container, new Dashboard()).addToBackStack(null).commit();
            }
        });

        change_password.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
               change_password();
            }
        });
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        getSupportFragmentManager().beginTransaction().replace(R.id.container, new Dashboard()).addToBackStack(null).commit();
    }


    public void change_password(){

        final View view = getLayoutInflater().inflate(R.layout.change_password, null);

        (view.findViewById(R.id.bt_close)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mBottomSheetDialog.dismiss();
            }
        });

        submit_change_password = view.findViewById(R.id.submit_change_password);

        npassword = view.findViewById(R.id.npassword);
        password = view.findViewById(R.id.password);

        submit_change_password.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                final String pass,npass;

                pass = password.getText().toString();
                npass = npassword.getText().toString();

                if (pass.isEmpty()){
                    func.vibrate();
                    func.error_toast("Old password is required");
                    return;
                }

                if (npass.isEmpty()){
                    func.vibrate();
                    func.error_toast("New password is required");
                    return;
                }

                func.startDialog();

                StringRequest request = new StringRequest(Request.Method.POST, Core.SITE_URL, new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        func.dismissDialog();

                        try {

                            JSONObject object = new JSONObject(response);
                            if (object.getString("error").equals("0")){
                                func.vibrate();
                                func.error_toast(object.getString("msg"));
                                return;
                            }

                            func.vibrate();
                            func.success_toast(object.getString("msg"));
                            mBottomSheetDialog.dismiss();

                        }catch (JSONException e){
                            e.printStackTrace();
                        }

                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        func.vibrate();
                        func.error_toast("No internet connection, try again");
                        func.dismissDialog();
                    }
                }){
                    @Override
                    protected Map<String, String> getParams() throws AuthFailureError {
                        Map<String, String> param = new HashMap<>();
                        param.put("action", "change_password");
                        param.put("student_id",student_id);
                        param.put("password", pass);
                        param.put("npassword", npass);
                        return  param;
                    }
                };

                RequestQueue queue = Volley.newRequestQueue(Main.this);
                queue.add(request);

            }
        });

        mBottomSheetDialog = new BottomSheetDialog(this);
        mBottomSheetDialog.setContentView(view);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            mBottomSheetDialog.getWindow().addFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS);
        }

        mBottomSheetDialog.show();
        mBottomSheetDialog.setOnDismissListener(new DialogInterface.OnDismissListener() {
            @Override
            public void onDismiss(DialogInterface dialog) {
                mBottomSheetDialog = null;
            }
        });

    }

    public void bottomSheet(){

        final View view = getLayoutInflater().inflate(R.layout.bottomsheet, null);

        (view.findViewById(R.id.bt_close)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mBottomSheetDialog.dismiss();
            }
        });

        recyclerView = (RecyclerView) view.findViewById(R.id.my_recycler_view);
        listAdapters = new ListAdapters(mData);
        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(this);
        recyclerView.setLayoutManager(layoutManager);
        recyclerView.setAdapter(listAdapters);

        mData = new ArrayList<>();


        try {

            JSONObject object = new JSONObject(response);
            JSONArray data = object.getJSONArray("hostel_data");

            for (int i = 0; i < data.length(); i++){
                JSONObject hostel_data = data.getJSONObject(i);
                mData.add(new Lists(hostel_data.getString("name"),hostel_data.getString("type"),"",hostel_data.getString("id"),"make_payment"));
            }


        }catch (JSONException e){
            e.printStackTrace();
        }

        mBottomSheetDialog = new BottomSheetDialog(this);
        mBottomSheetDialog.setContentView(view);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            mBottomSheetDialog.getWindow().addFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS);
        }

        mBottomSheetDialog.show();
        mBottomSheetDialog.setOnDismissListener(new DialogInterface.OnDismissListener() {
            @Override
            public void onDismiss(DialogInterface dialog) {
                mBottomSheetDialog = null;
            }
        });

    }
}