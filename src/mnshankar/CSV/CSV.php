<?php
namespace mnshankar\CSV;

class CSV
{
    protected $source;
    protected $handle;
    protected $headerRowExists = true;
    protected $delimiter = ',';
    protected $enclosure = '"';

    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    public function setHeaderRowExists($headerFlag = true)
    {
        $this->headerRowExists = $headerFlag;

        return $this;
    }

    public function setEnclosure($enclosure)
    {
        $this->enclosure = $enclosure;

        return $this;
    }

    public function setFileHandle($stream = 'php://output', $mode = 'r+')
    {
        $this->handle = fopen('php://output', $mode);

        return $this;
    }

    public function with($source, $headerRowExists = true, $mode = 'r+')
    {
        if (is_array($source)) { // fromArray
            $this->source = $source;
        } else {
            if (is_string($source)) { // fromfile
                $this->fromFile($source, $headerRowExists, $mode);
            } else {
                throw new \Exception('Source must be either an array or a file name');
            }
        }

        return $this;
    }

    public function fromArray($arr)
    {
        $this->source = $arr;

        return $this;
    }

	public function toArray()
	{
		return $this->source;
	}

    public function fromFile($filePath, $headerRowExists = true, $mode = 'r+')
    {
        $from = fopen($filePath, $mode);
        $arr = array();
        $this->headerRowExists = $headerRowExists;

        if ($headerRowExists) {
            // first header row
            $header = fgetcsv($from, 1000, $this->delimiter, $this->enclosure);
        }
        while (($data = fgetcsv($from, 1000, $this->delimiter, $this->enclosure)) !== false) {
            $arr[] = $headerRowExists ? array_combine($header, $data) : $data;
        }

        fclose($from);
        $this->source = $arr;

        return $this;
    }

    public function put($filePath, $mode = 'w+')
    {
        $this->handle = fopen($filePath, $mode);
        fwrite($this->handle, $this->toString());
        fclose($this->handle);
    }

    public function render($filename = 'export.csv', $mode = 'r+')
    {
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'private',
            'pragma' => 'cache'
        );
        $this->handle = fopen('php://output', $mode);

        return \Response::make($this->toString(), 200, $headers);
    }

    private function getCSV()
    {
        if ($this->headerRowExists) {
            $longest_row = max($this->source);
            $header = array_keys(array_dot($longest_row));
            fputcsv($this->handle, $header, $this->delimiter, $this->enclosure);
        }

        foreach ($this->source as $key => $row) {
            fputcsv($this->handle, array_dot($row), $this->delimiter, $this->enclosure);
        }
    }

	//this method is used by unit tests. So it is public.
    public function toString()
    {
        ob_start(); // buffer the output ...
        $this->handle = fopen('php://output', 'r+');
        $this->getCSV();

        return ob_get_clean(); //then return it as a string
    }
}
