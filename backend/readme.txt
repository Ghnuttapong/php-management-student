// state
    1. รอยืนยัน
    2. ยืนยันแล้ว
    3. สำเร็จ
    4. ไม่สำเร็จ

// pay status
    1. ผ่อนจ่าย
    2. จ่ายทั้งหมด
    3. เกินกำหนดชำระ
    4. รอชำระ

// status student
    1. กำลังศึกษา
    2. พ้นสภาพนักเรียน
    3. จบการศึกษา

// folder auth 
        login method post
            field name 
            -username
            -password

// folder students
        save.php method post
            field name
            -prefix
            -firstname
            -lastname
            -nickname
            -class
            -year
            -p_prefix
            -p_firstname
            -p_lastname
            -p_relative
            -phone
            -address
        
        update.php method post
            -id ที่ต้องการอัพเดท
            -prefix
            -firstname,
            -lastname,
            -nickname,
            -class,
            -year,
            -p_prefix,
            -p_firstname,
            -p_lastname,
            -p_relative,
            -phone
            -address,
            -status,
            -note ?

        show_detail.php method post
            -id ,
        
        show.php method get
        
        show_count.php method get

        graduated.php method post
            -year
            -class

// folder products
        delete.php method post
            -id 

        save.php method post
            -code,
            -name,
            -detail ?,
            -price,
            -category_id,

        update.php method post
            -id ที่ต้องการอัพเดท,
            -code,
            -name,
            -detail ?,
            -price,
            -status,
            -category_id,
        
        show_detail.php method post
            -id
        
        show.php method get

// folder users
        save.php method post
            -prefix,
            -firstname,
            -lastname,
            -phone ?,
            -username,
            -password,
            -role
        
        update.php method post
            -id ที่ต้องการอัพเดท,
            -prefix,
            -firstname,
            -lastname,
            -phone,
            -password,

        delete.php method post
            -id
        
        show.php method get
        
// folder orders
        product_cart_show.php method post
            -order_code
        
        product_cart_update.php method post
            -product_id type array,
            -product_qty type array,
            -order_code
        
        product_complete.php method post
            -order_id
        
        product_show.php method get
        
        product_pay.php method post
            -student_id,
            -pay,
            -status
        
        product_save.php method post
            -product_id type array,
            -product_qty type array,
            -student_id
        
        product_show_detail.php method post
            -order_code,
    
        term_show.php method get

        term_show_detail.php method post
            -student_id

        term_pay.php method post
            -student_id,
            -pay,
            -status
        
        term_confirm.php method post
            -student_id
        
        term_complete.php method post
            -student_id
        
        term_close.php method post
            -student_id,
            -status นักเรียน พ้นสภาพนักเรียน,

// folder setting
        #g_cate = category,
        #g_clss = class,
        #g_year = year,

        #save term fees
        #term

        g_cate_save.php method post
            -type

        g_cate_show.php method get

        g_cate_update.php method post
            -type
            -id
        
        g_class_update.php method post
            -id,
            -class,
            -year,
            -room

        g_class_show method get
        
        g_class_save method post
            -year,
            -class,
            -room

        g_class_delete.php method post
            -id

        term_update.php method post
            -year,
            -id,
            -class,
            -term_fees
        
        term_show.php method get
        
        term_save.php method post
            -year,
            -class,
            -term_fees