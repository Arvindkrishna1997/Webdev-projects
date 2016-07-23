<?php
$source="#include<iostream.h>
int main() {
    int N,sum=0;
    cin>>N;
    int i;
    int* A=new int[N];
    for(i=0;i<N;i++)
        {
        cin>>A[i];
         sum+=A[i];
         
        
    }
    cout<<sum;
    return 0;
}";
$myfile=fopen("input.txt","w");
fwrite($myfile,"6  1 2 3 4 10 11");



$myfile=fopen("programcplus.cpp","w");
fwrite($myfile,$source);
exec("del programcplus.exe");
$array="";
exec("g++ programcplus.cpp -o programcplus.exe 2>&1",$array);
if($array)
    var_dump($array);
else
{
     $out=shell_exec("programcplus.exe < input.txt");
    echo $out;
}
