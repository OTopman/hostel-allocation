package com.app.hostelallocation;

import android.app.DownloadManager;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import co.paystack.android.Paystack;
import co.paystack.android.PaystackSdk;
import co.paystack.android.Transaction;
import co.paystack.android.model.Card;
import co.paystack.android.model.Charge;

public class Payment extends Fragment {

    public Func func;
    public String hostel_id,response,student_id,email,matric;

    TextView name,type,payer_name;
    SharedPreferences sharedPreferences;

    EditText card_numbers,card_year,cvv;
    Button payment;

    Charge charge;

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View root = inflater.inflate(R.layout.payment, container, false);

        getActivity().setTitle("Proceed on payment");

        sharedPreferences = getActivity().getSharedPreferences("ALL_USER_INFO", Context.MODE_PRIVATE);
        response = sharedPreferences.getString("all_user_info", null);

        func = new Func(getActivity());
        Bundle bundle = getArguments();
        hostel_id = bundle.getString("view_id");

        type = root.findViewById(R.id.st_matric);
        name = root.findViewById(R.id.st_name);
        payer_name = root.findViewById(R.id.payer_name);

        card_numbers =  root.findViewById(R.id.card_numbers);
        card_year = root.findViewById(R.id.card_year);
        cvv = root.findViewById(R.id.cvvv);

        card_numbers.setText("5060666666666666666");
        card_year.setText("12/2021");
        cvv.setText("123");

        payment = root.findViewById(R.id.payment);

        PaystackSdk.initialize(getActivity());

        try {

            JSONObject object = new JSONObject(response);
            JSONArray data = object.getJSONArray("hostel_data");

            JSONObject student_info = object.getJSONObject("student_info");
            student_id = student_info.getString("id");
            email = student_info.getString("email");
            matric = student_info.getString("matric");

            payer_name.setText(student_info.getString("fname"));

            for (int i = 0; i < data.length(); i++){
                JSONObject hostel_data = data.getJSONObject(i);

                if (hostel_data.getString("id").equals(hostel_id)){
                    type.setText(hostel_data.getString("name"));
                    name.setText(hostel_data.getString("type"));

                    break;
                }

            }

        }catch (JSONException e){
            e.printStackTrace();
        }

        payment.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                Card card = new Card(card_numbers.getText().toString(), 8, 2022, cvv.getText().toString());

                if (!card.isValid()){
                    func.vibrate();
                    func.error_toast("Invalid card entered");
                    return;
                }

                if (card.isValid()) {
                    charge = new Charge();
                    charge.setCard(card);

                    func.startDialog();

                    charge.setAmount(10000 * 100);
                    charge.setEmail(email);

                    chargeCard();

                }

            }
        });


        return root;
    }

    private void chargeCard() {

        PaystackSdk.chargeCard(getActivity(), charge, new Paystack.TransactionCallback() {
            // This is called only after transaction is successful
            @Override
            public void onSuccess(Transaction transaction) {


                StringRequest request = new StringRequest(Request.Method.POST, Core.SITE_URL, new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        func.dismissDialog();

                        //func.error_toast(response.toString());

                        try {
                            JSONObject object = new JSONObject(response);

                            if (object.getString("error").equals("0")){
                                func.vibrate();
                                func.error_toast(object.getString("msg"));
                                return;
                            }

                            func.vibrate();

                            DownloadManager downloadmanager = (DownloadManager) getActivity().getSystemService(Context.DOWNLOAD_SERVICE);
                            Uri uri = Uri.parse(Core.URI+object.getString("file"));

                            DownloadManager.Request request2 = new DownloadManager.Request(uri);
                            request2.setTitle(matric);
                            request2.setDescription("Downloading");
                            request2.setNotificationVisibility(DownloadManager.Request.VISIBILITY_VISIBLE_NOTIFY_COMPLETED);
                            request2.setDestinationInExternalPublicDir(Environment.DIRECTORY_DOWNLOADS,"allocation");
                            downloadmanager.enqueue(request2);

                            Intent browserIntent = new Intent(Intent.ACTION_VIEW, Uri.parse(Core.URI+object.getString("file")));
                            startActivity(browserIntent);

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
                        param.put("action", "payment");
                        param.put("student_id",student_id);
                        param.put("hostel_id",hostel_id);
                        param.put("ref",transaction.getReference());
                        return  param;
                    }
                };

                RequestQueue queue = Volley.newRequestQueue(getActivity());
                queue.add(request);

            }

            // This is called only before requesting OTP
            // Save reference so you may send to server if
            // error occurs with OTP
            // No need to dismiss dialog
            @Override
            public void beforeValidate(Transaction transaction) {

                /*func.vibrate();
                func.dismissDialog();
                func.error_toast("Error Payment, try again");
                func.dismissDialog();*/
            }

            @Override
            public void onError(Throwable error, Transaction transaction) {
                // If an access code has expired, simply ask your server for a new one
                // and restart the charge instead of displaying error

                func.dismissDialog();
                func.vibrate();
                func.error_toast("Error Payment, try again");
                func.dismissDialog();
            }
        });
    }
}
