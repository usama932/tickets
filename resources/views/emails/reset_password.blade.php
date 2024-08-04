<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Unlock the power of data with expert insights and resources on business analysis. Our website offers a comprehensive guide to the latest trends, tools, and best practices in this dynamic field.">

    <!-- bootstar-link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- font-faimly -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,500;1,700&family=Work+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- <link rel="stylesheet" type="text/css" href="assets/css/style.css"> -->
    <title>Reset-Password</title>
</head>
<style>
    @media screen and (max-width: 425px) {
        .padd-t {
            padding: 20px 10px 10px 10px !important;
            font-size: 18px !important;
        }

    }
</style>

<body>
    <table style="width: 100%; max-width: 478px; margin: 0 auto;">
        <tr>
            <td>
                {{-- <div style="display:block; background-color: #003366; padding: 0 48px 0 45px;">
                    <img height="92px" width="164px"
                        src="{{ isset($payload['companyimage']) ? $payload['companyimage'] ?? asset('admin_assets/images/elmos-logo.png') : asset('admin_assets/images/elmos-logo.png') }}"
                        alt="elmos logo">
                </div> --}}
                <div style="background: #FFFFFF; box-shadow: 0px 0px 16px rgba(0, 0, 0, 0.08);">
                    <h1
                        style="font-style: normal; font-weight: 700;  font-size: 24px; line-height: 140%; color: #192A3E; padding: 30px 0px 0px 32px;">
                        Password Reset Email!</h1>
                    <div style="padding: 31px 28px 56px 32px;">
                        <p
                            style=" font-style: normal; font-weight: 400; font-size: 12px; line-height: 15px; color: #2B2B2B;">
                            Hi</p>
                        <p
                            style=" font-style: normal; font-weight: 400; font-size: 12px; line-height: 15px; color: #2B2B2B;">
                            You requested to change your password</p>

                        <p
                            style=" font-style: normal; font-weight: 400; font-size: 12px; line-height: 15px; color: #2B2B2B;">
                            You can now view your information and instruction how to change
                            your account settings.</p>
                        <p
                            style="font-style: normal; font-weight: 400; font-size: 12px; line-height: 15px; color: #2B2B2B;">
                            If the changes described above are accurate, no further action is needed.
                            If anything doesn’t look right, follow the link to make changes.
                            <a href="{{ $url }}"
                                style="background: #003366; border-radius: 6px; font-style: normal; font-weight: 500;font-size: 16px; line-height: 24px;padding: 8px 16px; color: #FFFFFF; border: none;margin-top: 10px; text-decoration: none;display: inline-block;">Reset
                                your Password</a>
                        </p>
                        <p
                            style=" font-style: normal; font-weight: 400; font-size: 12px; line-height: 15px; color: #2B2B2B;">
                            Thank you!</p>
                        <p
                            style=" font-style: normal; font-weight: 400; font-size: 12px; line-height: 15px; color: #2B2B2B;">
                            The Markhor Team.</p>

                    </div>
        <tr>
            <td style="background-color: #003366; padding: 24px; ">
                <div style="display: flex; flex-direction: column;gap: 7px;align-items: center;">
                    <div style="display: flex; gap: 24px; justify-content: center; align-items: center;">
                        <a style=" font-style: normal; font-weight: 400;font-size: 10px; line-height: 22px;color: #FFFFFF; text-decoration: none;"
                            href="#">Cookies policy</a>
                        <a style=" font-style: normal; font-weight: 400;font-size: 10px; line-height: 22px;color: #FFFFFF; text-decoration: none;"
                            href="#">Privacy policy</a>
                        <a style=" font-style: normal; font-weight: 400;font-size: 10px; line-height: 22px;color: #FFFFFF; text-decoration: none;"
                            href="#">Terms & conditions</a>
                    </div>
                  
                </div>

            </td>

        </tr>

        </div>
        </td>
        </tr>
        <td>

        </td>


    </table>








    <!-- ************************Scripts Start Here*********************************-->

    <!--------------------------------- Jquery --------------------------->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-------------------------------- Jquery Ends------------------------------->
    <!-- botstrap cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
