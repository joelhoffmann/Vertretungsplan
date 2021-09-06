<style>
    .custom-btn {
        width: 130px;
        height: 40px;
        padding: 10px 25px;
        border: 2px solid #000;
        font-family: 'Lato', sans-serif;
        font-weight: 500;
        background: transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        display: inline-block;
    }




    /* 15 */
    .btn-15 {
        background: #000;
        color: #fff;
        z-index: 1;
    }

    .btn-15:after {
        position: absolute;
        content: "";
        width: 0;
        height: 100%;
        top: 0;
        right: 0;
        z-index: -1;
        background: #e0e5ec;
        transition: all 0.3s ease;
    }

    .btn-15:hover {
        color: #000;
    }

    .btn-15:hover:after {
        left: 0;
        width: 100%;
    }

    .btn-15:active {
        top: 2px;
    }
</style>
<button id="submit-lbl" type="submit" name="submit" class="custom-btn btn-15">Read More</button>