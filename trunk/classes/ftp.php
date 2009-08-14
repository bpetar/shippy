<?
class ftp{

	var $id;
	var $user;
  var $pw;
  var $host;
  var $root_dir;
  var $cwd;
  var $mode = FTP_BINARY;

	/* Constructor
	 *
	 */
	function ftp(){
		global $ftp_host;
		global $ftp_user;
		global $ftp_pass;
		$this->host = $ftp_host;
		$this->user = $ftp_user;
		$this->pw = $ftp_pass;
		if($this->id = ftp_connect($this->host)){
      ftp_login($this->id, $this->user, $this->pw);
    }
	}

	/* Changes directories
	 * Returns TRUE on success or FALSE on error.
	 */
	function chdir($dir){
		return @ftp_chdir($this->id, $dir);
	}

	/* Deletes a file
	 * Returns TRUE on success or FALSE on error.
	 */
	function delete($path){
		return @ftp_delete($this->id, $path);
	}

	/* Uploads from an open file
	 * Returns TRUE on success or FALSE on error.
	 */
	function fput($remote, $fp){
		return @ftp_fput($this->id, $remote, $fp, $this->mode);
	}
	
	/* Creates a directory
	 * Returns the newly created directory name on success or FALSE on error.
	 */
	function mkdir($dir){
		return @ftp_mkdir($this->id, $dir);
	}

	/* Returns a list of files in the given directory
	 * Returns an array of filenames from the specified directory on success or FALSE on error.
	 */
	function nlist($dir){
		return @ftp_nlist($this->id, $dir);
	}
	
	/* Uploads a file to the FTP server
	 * Returns TRUE on success or FALSE on error.
	 */
	function put($remote, $loc){
		return @ftp_put($this->id, $remote, $loc, $this->mode);
	}

	/* Returns the current directory name
   * Returns the current directory or FALSE on error.
   */
	function pwd(){
		return @ftp_pwd($this->id);
	}

	/* Closes an FTP connection
	 * 
	 */
	function quit(){
		@ftp_quit($this->id);
	}

	/* Renames a file on the FTP server
	 * Returns TRUE on success or FALSE on error.
	 */
	function rename($from, $to){
		return @ftp_rename($this->id, $from, $to);
	}

	/* Removes a directory
   * Returns TRUE on success or FALSE on error.
   */
	function rmdir($dir){
		return @ftp_rmdir($this->id, $dir);
	}

	/* Returns the size of the given file
	 * Returns the file size on success, or -1 on error.
	 */
	function size($remote){
		return @ftp_size($this->id, $remote);
	}
}
?>
