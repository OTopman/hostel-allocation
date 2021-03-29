package com.app.hostelallocation;

import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.makeramen.roundedimageview.RoundedTransformationBuilder;
import com.squareup.picasso.Picasso;
import com.squareup.picasso.Transformation;

import java.util.List;

public class ListAdapters extends RecyclerView.Adapter<ListAdapters.MyViewHolder>{

    Context mContext;
    private List<Lists> mData;

    public ListAdapters(Context mContext, List<Lists> mData) {
        this.mContext = mContext;
        this.mData = mData;
    }

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {

        View view;
        view = LayoutInflater.from(parent.getContext()).inflate(R.layout.lists, parent,false);
        MyViewHolder viewHolder = new MyViewHolder(view);

        return viewHolder;
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, final int position) {
        holder.st_matric.setText(((Lists) mData.get(position)).getMatric());
        holder.st_name.setText(((Lists) mData.get(position)).getName());

        String is_click = ((Lists) mData.get(position)).getIs_click();

        Transformation transformation = new RoundedTransformationBuilder()
                .cornerRadiusDp(50)
                .oval(true)
                .build();

        if (!mData.get(position).getImage().isEmpty()){
            Picasso.get().load(mData.get(position).getImage()).transform(transformation).into(holder.st_image);
        }

        Bundle bundle = new Bundle();
        bundle.putString("view_id", ((Lists) mData.get(position)).getId());

        holder.click.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if (is_click.equals("view_student")){

                }

            }
        });



    }

    @Override
    public int getItemCount() {
        return mData.size();
    }

    public ListAdapters(List<Lists> mData){
        this.mData = mData;
    }

    public static class MyViewHolder extends RecyclerView.ViewHolder{

        private LinearLayout click;
        private ImageView st_image;
        private TextView st_matric,st_name,st_level;


        public MyViewHolder(@NonNull View itemView) {

            super(itemView);

            st_matric = (TextView) itemView.findViewById(R.id.st_matric);
            st_name = (TextView) itemView.findViewById(R.id.st_name);
            st_image = (ImageView) itemView.findViewById(R.id.st_image);
            click = (LinearLayout) itemView.findViewById(R.id.click);

        }
    }

}
